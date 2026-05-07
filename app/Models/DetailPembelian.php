<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'detail_pembelian';

    protected $fillable = [
        'riwayat_pembelian_id',
        // 'produk_id',
        'nama_produk',
        'harga_satuan',
        'keterangan',
        'jumlah',
        'subtotal',
    ];

    /**
     * Sembunyikan relasi 'riwayat' dari JSON output
     * Ini mencegah error parsing JSON di Android Studio.
     */
    protected $hidden = [
        'riwayat',
        'created_at',
        'updated_at'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function riwayat()
    {
        return $this->belongsTo(RiwayatPembelian::class, 'riwayat_pembelian_id');
    }
}