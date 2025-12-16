<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'no_telp',
        'penghuni_asrama',
        'alamat_gedung',
        'gambar',
        'remember_token',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function metodePembayarans()
    {
        return $this->hasMany(MetodePembayaran::class);
    }
}
