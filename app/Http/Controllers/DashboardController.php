<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Penjualan;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('dashboard.user');
        }

        return match (Auth::user()->role_id) {
            1 => redirect()->route('dashboard.superadmin'),
            2 => redirect()->route('dashboard.admin'),
            default => view('dashboard.user'),
        };
    }

    public function admin()
    {
        return view('dashboard.admin', [
            'totalProduk' => Produk::count(),
            'pesananMasuk' => Pesanan::where('status', 'Menunggu')->count(),
            'stokHabis' => Produk::where('status_ketersediaan', 'Habis')->count(),
            'penjualanBulanIni' => Penjualan::whereMonth('tanggal_penjualan', now()->month)->sum('total'),
        ]);
    }

    public function superadmin()
    {
        return view('dashboard.superadmin');
    }

    public function user()
    {
        return view('dashboard.user');
    }
}
