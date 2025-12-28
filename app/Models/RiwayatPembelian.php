<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembelian extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembelian'; // Paksa nama tabel sesuai database

    protected $fillable = [
        'user_id',
        'id_transaksi',
        'total_harga',
        'status',          // Status Bayar (Lunas/Belum Bayar)
        'status_antar',    // WAJIB: Untuk alur pengiriman (dikonfirmasi, siap_antar, selesai)
        'metode_pembayaran',
        'tipe_layanan',
    ];

    /**
     * Relasi ke User (Pelanggan)
     */
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Detail Pembelian (Daftar barang yang dibeli)
     * Digunakan agar admin bisa melihat rincian produk di tabel pesanan
     */
    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'riwayat_pembelian_id');
    }

    /**
     * Relasi ke Transaksi (Opsional jika Anda memiliki tabel transaksi terpisah)
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
}