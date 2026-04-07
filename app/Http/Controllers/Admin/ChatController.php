<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show all chats admin dashboard.
     */
    public function index()
    {
        $chats = Chat::with('user', 'messages')
                     ->orderBy('last_message_at', 'desc')
                     ->paginate(15);
        
        return view('admin.chats.index', compact('chats'));
    }

    /**
     * Show specific chat.
     */
    public function show(Chat $chat)
    {
        $chat->load('user', 'messages.sender');
        
        return view('admin.chats.show', compact('chat'));
    }

    /**
     * Send a reply message from admin.
     */
    public function sendReply(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin' => true,
        ]);
        
        // Update last message time
        $chat->update(['last_message_at' => now()]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }
        
        return back()->with('success', 'Message sent successfully');
    }

    /**
     * Close chat.
     */
    public function close(Chat $chat)
    {
        $chat->update(['status' => 'closed']);
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Chat closed',
            ]);
        }
        
        return back()->with('success', 'Chat closed successfully');
    }

    /**
     * Reopen chat.
     */
    public function reopen(Chat $chat)
    {
        $chat->update(['status' => 'open']);
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Chat reopened',
            ]);
        }
        
        return back()->with('success', 'Chat reopened successfully');
    }

    /**
     * Get chat data as JSON for AJAX.
     */
    public function getData(Chat $chat)
    {
        $chat->load('messages.sender');
        
        return response()->json([
            'success' => true,
            'chat' => $chat,
            'messages' => $chat->messages,
        ]);
    }

    /**
     * Poll for new messages (simple implementation).
     */
    public function pollMessages(Chat $chat)
    {
        $lastMessageId = request('last_id', 0);
        
        $newMessages = ChatMessage::where('chat_id', $chat->id)
                                  ->where('id', '>', $lastMessageId)
                                  ->orderBy('created_at', 'asc')
                                  ->get()
                                  ->load('sender');
        
        return response()->json([
            'success' => true,
            'messages' => $newMessages,
        ]);
    }

    /**
     * Get unread chats count.
     */
    public function getUnreadCount()
    {
        $count = Chat::whereHas('messages', function ($query) {
            $query->where('is_admin', false)
                  ->whereNull('read_at');
        })->where('status', 'open')->count();
        
        return response()->json([
            'success' => true,
            'unread_count' => $count,
        ]);
    }
}
