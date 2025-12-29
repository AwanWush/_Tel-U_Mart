<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\RiwayatPembelian; // Ganti Pesanan menjadi RiwayatPembelian
use App\Models\Banner;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();
        $produk = Produk::latest()->take(8)->get();

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
        // Berdasarkan struktur database Anda:
        // 'Belum Bayar' biasanya adalah status menunggu pembayaran
        // 'Lunas' adalah transaksi yang sudah berhasil
        return view('dashboard.admin', [
            'totalProduk' => Produk::count(),
            'pesananMasuk' => RiwayatPembelian::where('status', 'Belum Bayar')->count(), 
            'stokHabis' => Produk::where('stok', '<=', 0)->count(),
            'penjualanBulanIni' => RiwayatPembelian::where('status', 'Lunas')
                ->whereMonth('created_at', now()->month)
                ->sum('total_harga'),
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
    }
}