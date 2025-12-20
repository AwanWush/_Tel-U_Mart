<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKamar extends Model
{
    use HasFactory;

    protected $table = 'master_kamars';
    protected $fillable = ['lantai', 'nomor_kamar'];
    public $timestamps = false;
}