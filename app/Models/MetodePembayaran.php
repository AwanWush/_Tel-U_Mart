<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran'; // pastikan sesuai nama tabel di DB

    protected $fillable = [
        'user_id',
        'jenis',
        'keterangan',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
