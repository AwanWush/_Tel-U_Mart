<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembelian extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembelian';
    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah',
        'total_harga',
        'metode_pembayaran',
        'jenis_pemesanan',
        'lokasi_pengantaran',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
