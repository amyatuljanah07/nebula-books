<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke Cart
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    // Get total orders
    public function getTotalOrdersAttribute()
    {
        return $this->orders()->count();
    }

    // Get total spending
    public function getTotalSpendingAttribute()
    {
        return $this->orders()
            ->where('payment_status', 'paid')
            ->sum('total_amount');
    }
    
    // Scope active users
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is active
    public function isActive()
    {
        return $this->is_active;
    }

}
