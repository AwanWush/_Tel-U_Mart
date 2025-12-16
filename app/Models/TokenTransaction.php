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
        'nominal',
        'harga',
        'token_kode',
        'metode_pembayaran',
        'waktu_transaksi',
        'status',
    ];

    protected $casts = [
        'waktu_transaksi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
