@extends('layouts.admin')

@section('title', 'Chat - ' . $chat->user->name)

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('admin.chats.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div>
                    @if($chat->status === 'open')
                        <form action="{{ route('admin.chats.close', $chat) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="fas fa-times"></i> Close Chat
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.chats.reopen', $chat) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info">
                                <i class="fas fa-check"></i> Reopen Chat
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">
                                    <span class="avatar-initial rounded-circle bg-primary text-white">
                                        {{ strtoupper(substr($chat->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $chat->user->name }}</h5>
                                    <small class="text-muted">{{ $chat->user->email }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto ms-auto">
                            @if($chat->status === 'open')
                                <span class="badge bg-success">Open</span>
                            @else
                                <span class="badge bg-secondary">Closed</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="card-body chat-messages" id="chatMessages" style="height: 500px; overflow-y: auto; background-color: #f8f9fa;">
                    @forelse($chat->messages as $message)
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex {{ $message->is_admin ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="chat-bubble {{ $message->is_admin ? 'bg-primary text-white' : 'bg-light' }}" 
                                     style="max-width: 60%; padding: 12px 16px; border-radius: 12px;">
                                    <p class="mb-1">{{ $message->message }}</p>
                                    <small class="opacity-75">{{ $message->created_at->format('H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-comments fa-2x mb-3 d-block opacity-25"></i>
                        <p>No messages yet. Start the conversation!</p>
                    </div>
                    @endforelse
                </div>

                <!-- Reply Form -->
                @if($chat->status === 'open')
                <div class="card-footer bg-light border-top">
                    <form id="replyForm" method="POST" action="{{ route('admin.chats.reply', $chat) }}">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" placeholder="Type your reply..." rows="1" 
                                      style="resize: none;" required></textarea>
                            <button type="submit" class="btn btn-primary" id="sendBtn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="card-footer bg-light border-top">
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-lock me-2"></i>
                        This chat is closed. You can only view messages.
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to bottom of messages
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Handle form submission
    const replyForm = document.getElementById('replyForm');
    if (replyForm) {
        replyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const textarea = this.querySelector('textarea');
            const message = textarea.value.trim();
            
            if (!message) return;

            fetch('{{ route("admin.chats.reply", $chat) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    textarea.value = '';
                    // Reload page to show new message
                    setTimeout(() => location.reload(), 500);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    // Poll for new messages every 3 seconds
    setInterval(function() {
        const lastMessageId = document.querySelector('.chat-bubble:last-child');
        const lastId = lastMessageId ? lastMessageId.dataset.id : 0;
        
        fetch('{{ route("admin.chats.poll", $chat) }}?last_id=' + lastId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.messages.length > 0) {
                    location.reload();
                }
            });
    }, 3000);
});
</script>
@endsection
