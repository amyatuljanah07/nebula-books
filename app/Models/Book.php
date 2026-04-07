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

   
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
  
    public function getTotalSoldAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }
   
    public function isAvailable($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    public function reduceStock($quantity)
    {
        if ($this->isAvailable($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }


    public function restoreStock($quantity)
    {
        $this->increment('stock', $quantity);
    }
}