<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Penjualan;
use App\Models\Banner;
use App\Models\KategoriProduk;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();
        $produk = Produk::latest()->take(8)->get(); // ambil 8 produk terbaru

        if (!Auth::check() || Auth::user()->role_id > 2) {
            return $this->user();
        }

        return match (Auth::user()->role_id) {
            1 => redirect()->route('dashboard.superadmin'),
            2 => redirect()->route('dashboard.admin'),
            default => view('dashboard.user', compact('banners', 'produk')),
        };
    }
    
    public function superadmin()
    {
        return view('dashboard.superadmin');
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

    public function user()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();

        $produk = Produk::with('marts')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $latestProducts = Produk::orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        $kategoriProduk = KategoriProduk::with([
            'produkAktif' => function ($query) {
                $query
                    ->with(['marts'])
                    ->latest()
                    ->take(7);
            }
        ])->get();

        return view('dashboard.user', compact('banners', 'produk', 'latestProducts', 'kategoriProduk'));
        // return view('dashboard.user', [
        //     'banners' => $banners,
        //     'produk' => $produk,
        //     'latestProducts' => $latestProducts,
        //     'kategoriProduk' => $kategoriProduk
        // ]);
    }
}
