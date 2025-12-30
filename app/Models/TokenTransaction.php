<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenTransaction extends Model
{
    use HasFactory;

    protected $table = 'token_transactions';

    protected $fillable = [
        'user_id',
        'gedung',
        'kamar',
        'nama_penghuni',
        'nomor_hp',
        'nominal',
        'total_harga',
        'kode_token',
        'metode',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
