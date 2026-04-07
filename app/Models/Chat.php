<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user associated with the chat.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the chat.
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get unread messages count.
     */
    public function unreadMessagesCount()
    {
        return $this->messages()->where('is_admin', false)->whereNull('read_at')->count();
    }

    /**
     * Get latest message.
     */
    public function latestMessage()
    {
        return $this->messages()->latest('created_at')->first();
    }
}
