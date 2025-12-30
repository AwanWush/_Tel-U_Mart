<?php

namespace App\Models;

use App\Models\Scopes\ActiveMartScope;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'status_ketersediaan',
        'is_active',
        'persentase_diskon',
    ];

    public function kategori()
    {
        // Di SQL nama tabelnya 'kategori_produk'
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function marts()
    {
        // Menggunakan belongsToMany karena relasi melalui tabel produk_mart
        return $this->belongsToMany(Mart::class, 'produk_mart', 'produk_id', 'mart_id');
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

    // protected static function booted()
    // {
    //     static::addGlobalScope(new ActiveMartScope);
    // }

    public function activeMart()
    {
        return $this->marts->firstWhere('id', optional(activeMart())->id)
            ?? $this->marts->first();
    }

    public function highlightedMarts()
    {
        $activeMart = activeMart();

        return $this->marts->map(function ($mart) use ($activeMart) {
            return [
                'id' => $mart->id,
                'nama' => $mart->nama_mart,
                'is_active' => $activeMart && $mart->id === $activeMart->id,
            ];
        });
    }
}
