<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'nama_custom',
        'jabatan',
        'nama_bank',
        'nomor_rekening',
        'gaji',
        'tanggal_gaji',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}