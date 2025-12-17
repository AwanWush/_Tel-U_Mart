<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriProduk;
use App\Models\Mart;
use App\Models\ProdukVariant;

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

    public function variants()
    {
        return $this->hasMany(ProdukVariant::class, 'produk_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProdukReview::class, 'produk_id');
    }

    public function ratingAvg()
    {
        return $this->reviews()->avg('rating');
    }
    
}
