<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'birth_date',
        'gender',
    ];

    

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/avatars/' . $this->avatar)
            : asset('images/default-avatar.png');
    }
}