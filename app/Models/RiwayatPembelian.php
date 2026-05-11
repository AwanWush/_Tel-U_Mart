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
        'kurir_id',        
        'id_transaksi',
        'total_harga',
        'ongkir_driver',
        'status',          
        'status_antar',    
        'metode_pembayaran',
        'alamat_pengantaran',
        'tipe_layanan',
        'jarak',
        'durasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Tambahkan relasi detail agar kurir bisa melihat APA yang harus diantar
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

    // Di dalam class RiwayatPembelian
// Di dalam class RiwayatPembelian
public function galonTransaction()
{
    return $this->hasOne(GalonTransaction::class, 'id', 'id_transaksi_raw');
}

// Tambahkan Accessor ini untuk mempermudah query
public function getIdTransaksiRawAttribute()
{
    return str_replace(['COD-', 'MIDTRANS-'], '', $this->id_transaksi);
}
}