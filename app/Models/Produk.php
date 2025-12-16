<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mart;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function marts()
    {
        return $this->belongsToMany(
            Mart::class,
            'produk_mart',    
            'produk_id',    
            'mart_id'  
        );
    }
}
