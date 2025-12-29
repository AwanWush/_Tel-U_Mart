<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $fillable = ['nama_kategori'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }

    public function produkAktif()
    {
        return $this->hasMany(Produk::class, 'kategori_id')
            ->where('is_active', true);
    }

    public function produkAktifByMart(?Mart $mart)
    {
        return Produk::query()
            ->where('kategori_id', $this->id)
            ->where('is_active', true)
            ->when($mart, function ($q) use ($mart) {
                $q->whereHas('marts', function ($m) use ($mart) {
                    $m->where('mart.id', $mart->id);
                });
            })
            ->with('marts')
            ->latest();
    }
}
