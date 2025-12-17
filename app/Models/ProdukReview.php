<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukReview extends Model
{
    protected $fillable = [
        'produk_id',
        'user_id',
        'rating',
        'ulasan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
