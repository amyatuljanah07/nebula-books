@extends('layouts.admin')

@section('title', 'Customer Chats')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-2">
        <div>
            <h2 class="mb-1">Customer Chats</h2>
            <p class="text-muted mb-0">Manage customer support conversations</p>
        </div>
        <div>
            <span class="badge bg-primary">{{ $chats->total() }} Total</span>
        </div>
    </div>

    @if($chats->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Conversations</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Last Message</th>
                                <th>Status</th>
                                <th>Unread</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chats as $chat)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded-circle bg-primary text-white">
                                                {{ strtoupper(substr($chat->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $chat->user->name }}</h6>
                                            <small class="text-muted">{{ $chat->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($chat->latestMessage())
                                        <p class="mb-0 text-truncate">{{ Str::limit($chat->latestMessage()->message, 50) }}</p>
                                    @else
                                        <span class="text-muted">No messages</span>
                                    @endif
                                </td>
                                <td>
                                    @if($chat->status === 'open')
                                        <span class="badge bg-success">Open</span>
                                    @else
                                        <span class="badge bg-secondary">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $unread = $chat->messages()
                                            ->where('is_admin', false)
                                            ->whereNull('read_at')
                                            ->count();
                                    @endphp
                                    @if($unread > 0)
                                        <span class="badge bg-danger">{{ $unread }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $chat->last_message_at ? $chat->last_message_at->diffForHumans() : '-' }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.chats.show', $chat) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-comments"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            {{ $chats->links() }}
        </div>
    </div>
    @else
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        No customer chats yet
    </div>
    @endif
</div>
@endsection
