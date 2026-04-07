<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat page or redirect to login
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login to start chatting');
        }

        $user = Auth::user();
        
        // Get or create open chat
        $chat = Chat::where('user_id', $user->id)
                    ->where('status', 'open')
                    ->first();
        
        if (!$chat) {
            $chat = Chat::create([
                'user_id' => $user->id,
                'status' => 'open',
            ]);
        }

        // Mark messages as read
        ChatMessage::where('chat_id', $chat->id)
                   ->where('is_admin', false)
                   ->whereNull('read_at')
                   ->update(['read_at' => now()]);

        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        return view('chat.index', compact('chat', 'messages'));
    }

    /**
     * Store new message
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::find($validated['chat_id']);

        // Check if user owns this chat
        if ($chat->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized');
        }

        ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin' => false,
        ]);

        $chat->update(['last_message_at' => now()]);

        return back()->with('success', 'Message sent');
    }
}
