<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promosi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromosiController extends Controller
{
    public function index(Request $request)
    {
        $query = Promosi::orderBy('order')->orderBy('created_at', 'desc');

        // Filter for active promosi for public access
        if (!request()->user() || $request->has('public')) {
            $query->where('is_active', true);
            
            // Filter by date range if provided
            if ($request->has('filter') && $request->filter === 'active') {
                $now = now()->toDateString();
                $query->where(function($q) use ($now) {
                    $q->whereNull('start_date')
                      ->orWhere('start_date', '<=', $now);
                })->where(function($q) use ($now) {
                    $q->whereNull('end_date')
                      ->orWhere('end_date', '>=', $now);
                });
            }
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $promosis = $query->paginate(10);
        return response()->json($promosis);
    }

    public function show($id)
    {
        $promosi = Promosi::findOrFail($id);
        // For public access, only show active promosi
        if (!request()->user() && !$promosi->is_active) {
            abort(404);
        }
        return response()->json($promosi);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            'link' => 'nullable|string|max:500',
            'link_text' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle image file upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/promosi', $filename, 'public');
            $validated['image'] = $path;
        }

        // Remove file input from validated array
        unset($validated['image_file']);

        // Set default values
        if (!isset($validated['type'])) {
            $validated['type'] = 'general';
        }
        if (!isset($validated['order'])) {
            $validated['order'] = 0;
        }
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        $promosi = Promosi::create($validated);
        return response()->json($promosi, 201);
    }

    public function update(Request $request, $id)
    {
        $promosi = Promosi::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            'link' => 'nullable|string|max:500',
            'link_text' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle image file upload
        if ($request->hasFile('image_file')) {
            // Delete old image if exists
            if ($promosi->image && Storage::disk('public')->exists($promosi->image)) {
                Storage::disk('public')->delete($promosi->image);
            }

            $file = $request->file('image_file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/promosi', $filename, 'public');
            $validated['image'] = $path;
        }

        // Remove file input from validated array
        unset($validated['image_file']);

        $promosi->update($validated);
        return response()->json($promosi);
    }

    public function destroy($id)
    {
        $promosi = Promosi::findOrFail($id);
        
        // Delete image file if exists
        if ($promosi->image && Storage::disk('public')->exists($promosi->image)) {
            Storage::disk('public')->delete($promosi->image);
        }
        
        $promosi->delete();
        return response()->json(['message' => 'Promosi deleted successfully']);
    }
}
