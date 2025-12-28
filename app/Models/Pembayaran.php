<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'user_id',
        'kategori',
        'keterangan',
        'telepon',
        'bank',
        'norek',
    ];
}
