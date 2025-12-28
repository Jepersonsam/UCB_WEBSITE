<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReply;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
     * Reply to a contact message.
     */
    public function reply(Request $request, string $id)
    {
        $message = ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'reply_message' => 'required|string|min:10',
            'admin_name' => 'nullable|string|max:255',
        ]);

        try {
            $adminName = $validated['admin_name'] ?? $request->user()->name ?? 'Admin UCB';
            
            // Send email reply
            Mail::to($message->email)
                ->send(new ContactMessageReply(
                    $message,
                    $validated['reply_message'],
                    $adminName
                ));

            Log::info('Contact message reply sent', [
                'message_id' => $message->id,
                'recipient' => $message->email,
                'admin_name' => $adminName,
            ]);

            return response()->json([
                'message' => 'Balasan berhasil dikirim ke email ' . $message->email,
                'success' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send contact message reply', [
                'message_id' => $message->id,
                'recipient' => $message->email,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Gagal mengirim balasan: ' . $e->getMessage(),
                'success' => false,
            ], 500);
        }
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
