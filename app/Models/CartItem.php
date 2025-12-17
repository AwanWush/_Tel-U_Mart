<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'qty'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
