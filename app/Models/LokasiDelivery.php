<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiDelivery extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'lokasi_delivery';

    // Kolom yang boleh diisi
    protected $fillable = [
        'nama_lokasi',
        'alamat',
    ];
}
