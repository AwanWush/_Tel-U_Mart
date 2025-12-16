<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalonTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_galon',
        'harga_satuan',
        'jumlah',
        'total_harga',
        'catatan',
        'status',
        'waktu_transaksi',
    ];
}
