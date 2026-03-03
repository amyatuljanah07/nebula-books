<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'sinopsis',
        'tahun_terbit',
        'penerbit',
        'price',
        'stock',
        'image',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    // Get total sold
    public function getTotalSoldAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }
    // Check if book is available
    public function isAvailable($quantity = 1)
    {
        return $this->stock >= $quantity;
    }
    // Reduce stock after order
    public function reduceStock($quantity)
    {
        if ($this->isAvailable($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    // Restore stock if order cancelled
    public function restoreStock($quantity)
    {
        $this->increment('stock', $quantity);
    }
}