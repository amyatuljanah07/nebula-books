<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'payment_proof',
        'payment_deadline',
        'shipping_address',
        'phone',
        'notes',
        'city',
        'postal_code'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'payment_deadline' => 'datetime'
    ];

   
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }

 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

 
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

 
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

  
    public function scopePaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    public function isCompleted()
    {
        return $this->status === 'completed' && $this->payment_status === 'paid';
    }

    public function isPaymentExpired()
    {
        if (!$this->payment_deadline) {
            return false;
        }

        if ($this->payment_status === 'paid') {
            return false;
        }
        
        return now()->isAfter($this->payment_deadline);
    }

    public function getTimeRemainingAttribute()
    {
        if ($this->isPaymentExpired()) {
            return 0;
        }

        if (!$this->payment_deadline) {
            return null;
        }

        return now()->diffInSeconds($this->payment_deadline, false);
    }

  
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }
}