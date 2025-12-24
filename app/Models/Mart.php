<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
use App\Models\Scopes\ActiveMartScope;

class Mart extends Model
{
    protected $table = 'mart'; // pastikan nama tabel benar
    protected $fillable = ['nama_mart', 'alamat', 'deskripsi'];

    /**
     * SEMUA PRODUK di mart ini (tanpa filter mart aktif)
     */
    public function produkAll()
    {
        return $this->belongsToMany(
            Produk::class,
            'produk_mart',
            'mart_id',
            'produk_id'
        );
    }

    /**
     * PRODUK AKTIF (kena global scope mart)
     */
    public function produk()
    {
        return $this->belongsToMany(
            Produk::class,
            'produk_mart',
            'mart_id',
            'produk_id'
        );
    }
}
