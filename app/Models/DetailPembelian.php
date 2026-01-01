<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    // Sesuaikan nama tabel jika di database tidak pakai akhiran 's'
    protected $table = 'detail_pembelian';

    // protected $fillable = [
    //     'riwayat_pembelian_id',
    //     'produk_id',
    //     'qty',
    //     'harga_satuan',
    //     'nama_mart'
    // ];
    use HasFactory;

    protected $fillable = [
        'riwayat_pembelian_id',
        'produk_id',
        'nama_produk',
        'harga_satuan',
        'keterangan',
        'qty',
        'jumlah',
        'subtotal',
        'nama_mart'
    ];

    // Relasi balik ke Produk agar bisa ambil Nama Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function riwayat()
    {
        return $this->belongsTo(RiwayatPembelian::class);
    }
}