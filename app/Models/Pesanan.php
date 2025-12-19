<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    public $timestamps = false; // PENTING

    protected $fillable = [
        'user_id',
        'admin_id',
        'mart_id',
        'lokasi_id',
        'tanggal_pesan',
        'jenis_pesanan',
        'status',
        'total',
        'metode_pembayaran',
    ];

    // RELASI
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
