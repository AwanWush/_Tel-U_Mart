<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;

class PesananController extends Controller
{
    public function index()
    {
        // Narik data pesanan + user + barang yang dibeli
        $pesanan = RiwayatPembelian::with(['user', 'details'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.produk.pesanan.index', compact('pesanan'));
    }
}