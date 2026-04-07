<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'is_admin',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the chat associated with the message.
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Mark message as read.
     */
    public function markAsRead()
    {
        if (!$this->is_admin && !$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }
}
