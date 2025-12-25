<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('order')->orderBy('name')->get();
        return response()->json($members);
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:Soprano,Alto,Tenor,Bass,Conductor',
            'position' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'badges' => 'nullable|array',
            'badges.*' => 'string|max:50',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('members', 'public');
        }

        // Handle badges array
        if ($request->has('badges') && is_array($request->badges)) {
            $validated['badges'] = array_values(array_filter($request->badges));
        }

        // Handle boolean
        $validated['is_active'] = $request->has('is_active') ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN) : true;

        $member = Member::create($validated);
        
        return response()->json($member, 201);
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        // For POST requests with FormData, Laravel should read it correctly
        // For PUT requests, we need to handle FormData manually
        // Since we're now using POST with _method=PUT, FormData should work
        $combinedData = $request->all();
        $postData = $_POST ?? [];
        
        // If request->all() is empty (PUT request), try $_POST
        if (empty($combinedData) && $request->method() === 'PUT') {
            if (!empty($postData)) {
                $request->merge($postData);
                $combinedData = $postData;
            }
        }
        
        // Log raw request for debugging
        \Log::info('Member Update - Raw Request', [
            'member_id' => $id,
            'all_input' => $request->all(),
            'combined_data' => $combinedData,
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'has_name' => $request->has('name'),
            'name_value' => $request->input('name'),
        ]);
        
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'role' => 'nullable|in:Soprano,Alto,Tenor,Bass,Conductor',
            'position' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:51200',
            'badges' => 'nullable|array',
            'badges.*' => 'string|max:50',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Build update data - read from validated and combinedData
        $updateData = [];
        
        // Handle avatar upload first
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($member->avatar) {
                Storage::disk('public')->delete($member->avatar);
            }
            $updateData['avatar'] = $request->file('avatar')->store('members', 'public');
        }
        
        // Name - read from validated or combinedData
        if (isset($validated['name']) && $validated['name'] !== null && $validated['name'] !== '') {
            $updateData['name'] = $validated['name'];
        } elseif (isset($combinedData['name']) && $combinedData['name'] !== null && $combinedData['name'] !== '') {
            $updateData['name'] = $combinedData['name'];
        }
        
        // Role - read from validated or combinedData
        if (isset($validated['role']) && $validated['role'] !== null && $validated['role'] !== '') {
            $updateData['role'] = $validated['role'];
        } elseif (isset($combinedData['role']) && $combinedData['role'] !== null && $combinedData['role'] !== '') {
            $updateData['role'] = $combinedData['role'];
        }
        
        // Position - read from validated or combinedData
        if (isset($validated['position'])) {
            $updateData['position'] = $validated['position'] ?: null;
        } elseif (isset($combinedData['position'])) {
            $updateData['position'] = $combinedData['position'] ?: null;
        }
        
        // Badges - handle both array and badges[0] format
        if (isset($validated['badges']) && is_array($validated['badges'])) {
            $updateData['badges'] = array_values(array_filter($validated['badges']));
        } elseif (isset($combinedData['badges']) && is_array($combinedData['badges'])) {
            $updateData['badges'] = array_values(array_filter($combinedData['badges']));
        } else {
            // Check for badges[0], badges[1], etc. from combinedData
            $badgesKeys = array_filter(array_keys($combinedData), function($key) {
                return preg_match('/^badges\[/', $key);
            });
            if (!empty($badgesKeys)) {
                $badgesArray = [];
                foreach ($badgesKeys as $key) {
                    $value = $combinedData[$key];
                    if (!empty($value)) {
                        $badgesArray[] = $value;
                    }
                }
                $updateData['badges'] = $badgesArray;
            }
        }
        
        // Is active - read from validated or combinedData
        if (isset($validated['is_active'])) {
            $updateData['is_active'] = $validated['is_active'];
        } elseif (isset($combinedData['is_active'])) {
            $updateData['is_active'] = filter_var($combinedData['is_active'], FILTER_VALIDATE_BOOLEAN);
        }
        
        // Order - read from validated or combinedData
        if (isset($validated['order'])) {
            $updateData['order'] = $validated['order'];
        } elseif (isset($combinedData['order'])) {
            $updateData['order'] = (int) $combinedData['order'];
        }

        // Log update data
        \Log::info('Member Update - Update Data', [
            'member_id' => $id,
            'update_data' => $updateData,
            'update_data_count' => count($updateData),
            'request_all' => $request->all(),
            '_POST' => $postData,
            'combined_data' => $combinedData,
            'name_from_combined' => $combinedData['name'] ?? 'NOT_FOUND',
            'role_from_combined' => $combinedData['role'] ?? 'NOT_FOUND',
            'badges_keys' => array_filter(array_keys($combinedData), function($key) {
                return preg_match('/^badges\[/', $key);
            }),
        ]);

        // Update member
        if (!empty($updateData)) {
            \Log::info('Member Update - Executing Update', [
                'member_id' => $id,
                'update_data' => $updateData,
            ]);
            
            $member->update($updateData);
            $member->refresh();
            
            \Log::info('Member Update - Update Executed', [
                'member_id' => $id,
                'member_name' => $member->name,
                'member_role' => $member->role,
            ]);
        } else {
            \Log::warning('Member Update - No Data to Update', [
                'member_id' => $id,
                '_POST' => $postData,
                'validated' => $validated,
            ]);
        }
        
        // Log after update
        \Log::info('Member Update - After Update', [
            'member_id' => $id,
            'member_name' => $member->name,
            'member_role' => $member->role,
            'member_position' => $member->position,
            'member_is_active' => $member->is_active,
            'member_order' => $member->order,
            'member_badges' => $member->badges,
        ]);
        
        return response()->json($member);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        
        // Delete avatar if exists
        if ($member->avatar) {
            Storage::disk('public')->delete($member->avatar);
        }
        
        $member->delete();
        
        return response()->json(['message' => 'Member deleted successfully']);
    }
}

