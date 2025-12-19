<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('user')
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        return view('pesanan.admin.index', compact('pesanan'));
    }
}
