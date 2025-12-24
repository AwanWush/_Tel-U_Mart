<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveMartScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function booted()
    {
        static::addGlobalScope('activeMart', function (Builder $query) {
            $user = Auth::user();

            if ($user && $user->active_mart_id) {
                $query->whereHas('marts', function ($q) use ($user) {
                    $q->where('mart.id', $user->active_mart_id);
                });
            }
        });
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
