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
        'lokasi_id',      
        'alamat_gedung',
        'nomor_kamar',     
        'gambar',
        'remember_token',
        'email_verified_at',
        'active_mart_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function lokasi()
    {
        return $this->belongsTo(LokasiDelivery::class, 'lokasi_id', 'id');
    }

    public function getAlamatLengkapAttribute()
    {
        $gedung = $this->lokasi ? $this->lokasi->nama_lokasi : ($this->alamat_gedung ?? 'Gedung belum diset');
        $kamar = $this->nomor_kamar ? "Kamar " . $this->nomor_kamar : 'Kamar belum diset';
        
        return "{$gedung} - {$kamar}";
    }


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

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProdukReview::class);
    }

    public function activeMart()
    {
        return $this->belongsTo(Mart::class, 'active_mart_id');
    }

    
}