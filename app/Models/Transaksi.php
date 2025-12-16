<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // nama tabel di database kamu

    protected $fillable = [
        'user_id',
        'produk_id',
        'status',
        'metode_pembayaran',
        'total',
        'created_at',
    ];

    // Relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel produk (jika ada tabel produk)
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
