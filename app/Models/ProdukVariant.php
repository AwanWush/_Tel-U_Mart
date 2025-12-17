<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVariant extends Model
{
    protected $fillable = [
        'produk_id',
        'nama',
        'harga',
        'stok'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
