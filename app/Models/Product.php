<?php

namespace App\Models;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'stock'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
