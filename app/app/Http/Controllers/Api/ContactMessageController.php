<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($validated);

        return response()->json([
            'message' => 'Pesan berhasil dikirim',
            'data' => $message,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Mark as read if not already read
        if (!$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
        
        return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'is_read' => 'sometimes|boolean',
        ]);

        if (isset($validated['is_read'])) {
            $validated['read_at'] = $validated['is_read'] ? now() : null;
        }

        $message->update($validated);

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return response()->json(['message' => 'Pesan berhasil dihapus']);
    }
}
