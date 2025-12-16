<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mart extends Model
{
    protected $table = 'mart'; // pastikan nama tabel benar
    protected $fillable = ['nama_mart'];

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
