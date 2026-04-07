@extends('layouts.app')

@section('title', 'Customer Support - NebulaBooks')

@section('styles')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 550px;
        overflow-y: auto;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }

    .chat-container::-webkit-scrollbar {
        width: 6px;
    }

    .chat-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .chat-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .chat-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .chat-message {
        display: flex;
        margin-bottom: 12px;
        align-items: flex-end;
        gap: 8px;
    }
    
    .chat-message.user {
        justify-content: flex-end;
    }

    .chat-message.admin {
        justify-content: flex-start;
    }
    
    .message-wrapper {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .message-wrapper.user {
        align-items: flex-end;
    }

    .message-wrapper.admin {
        align-items: flex-start;
    }
    
    .message-bubble {
        padding: 12px 16px;
        border-radius: 18px;
        word-wrap: break-word;
        word-break: break-word;
        font-size: 14px;
        line-height: 1.6;
        max-width: 70%;
        min-width: 50px;
    }
    
    .message-bubble.user {
        background: #6366f1;
        color: white;
        border-radius: 18px 4px 18px 18px;
    }
    
    .message-bubble.admin {
        background: white;
        border: 1px solid #ddd;
        color: #1f2937;
        border-radius: 4px 18px 18px 18px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .message-time {
        font-size: 11px;
        color: #9ca3af;
        padding: 0 4px;
        flex-shrink: 0;
    }
    
    textarea.form-control {
        resize: none;
        max-height: 120px;
        font-size: 14px;
        border-radius: 8px;
    }

    .empty-state {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #999;
        flex-direction: column;
        gap: 12px;
    }

    .empty-state i {
        font-size: 48px;
        opacity: 0.2;
    }

    .card-header h5 {
        font-weight: 600;
        font-size: 16px;
    }

    .input-group .btn {
        padding: 10px 20px;
        font-weight: 500;
    }

    .card-footer {
        border-radius: 0 0 8px 8px;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i>Customer Support Chat
                </h5>
                <span class="badge {{ $chat->status === 'open' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                    {{ $chat->status === 'open' ? '● Open' : '● Closed' }}
                </span>
            </div>

            <!-- Messages Container -->
            <div class="chat-container" id="chatContainer">
                @forelse($messages as $message)
                <div class="chat-message {{ $message->is_admin ? 'admin' : 'user' }}">
                    <div class="message-wrapper {{ $message->is_admin ? 'admin' : 'user' }}">
                        <div class="message-bubble {{ $message->is_admin ? 'admin' : 'user' }}">
                            {{ $message->message }}
                        </div>
                        <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <p>No messages yet. Start the conversation!</p>
                </div>
                @endforelse
            </div>

            <!-- Form -->
            <div class="card-footer bg-white border-top">
                @if($chat->status === 'open')
                <form action="{{ route('chat.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                    <div class="input-group input-group-lg">
                        <textarea name="message" class="form-control" placeholder="Type your message here..." rows="2" required style="border-radius: 8px 0 0 8px;"></textarea>
                        <button type="submit" class="btn btn-primary" style="border-radius: 0 8px 8px 0;">
                            <i class="fas fa-paper-plane me-2"></i>Send
                        </button>
                    </div>
                    @error('message')
                    <small class="text-danger d-block mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                    @enderror
                </form>
                @else
                <div class="alert alert-warning mb-0 d-flex align-items-center" style="border-radius: 8px;">
                    <i class="fas fa-lock me-2"></i>This chat is closed. You cannot send messages.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-scroll to bottom when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 100);
        }
    });

    // Auto-scroll when page is shown (after form submission)
    window.addEventListener('pageshow', function() {
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });
</script>
@endsection
