<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Get all users for the chat dropdown
     */
    public function getUsers()
    {
        $users = User::where('id', '!=', auth()->id())
            ->where('is_blocked', false)
            ->orderBy('name')
            ->get();
        
        return response()->json($users);
    }

    /**
     * Get messages for a specific conversation
     */
    public function getMessages($userId)
    {
        $messages = Message::where(function($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                  ->where('recipient_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('recipient_id', auth()->id());
        })
        ->orderBy('created_at')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $userId)
               ->where('recipient_id', auth()->id())
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    /**
     * Send a message
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id|different:' . auth()->id(),
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
            'content' => $validated['content'],
        ]);

        return response()->json($message);
    }
}
