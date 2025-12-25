<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembelian extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembelian'; // Paksa nama tabel sesuai phpMyAdmin

    protected $fillable = [
        'user_id',
        'id_transaksi',
        'total_harga',
        'status',
        'metode_pembayaran',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Jika ingin menghubungkan ke transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
}