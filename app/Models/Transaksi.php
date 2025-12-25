<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Nama tabel di database Anda adalah 'transaksi'
    protected $table = 'transaksi';

    // Sesuaikan fillable dengan kolom yang ada di SQL
    protected $fillable = [
        'user_id',
        'status',
        'total_harga',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}