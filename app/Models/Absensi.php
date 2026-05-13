<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Nama tabel harus sesuai dengan yang ada di database
    protected $table = 'absensis';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'jam_masuk',
        'jam_pulang',
        'koordinat_absen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}