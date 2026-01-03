<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\ProdukReview;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    // USER: list produk
    public function index(Request $request)
    {
        // $kategoriId = $request->kategori;

        // // Ambil data kategori
        // $kategori = KategoriProduk::with(['produk' => function ($q) {
        //     $q->where('is_active', true)->latest();
        // }])->get();

        // // Query untuk filter
        // $produk = Produk::where('is_active', true)
        //     ->when($kategoriId, function ($q) use ($kategoriId) {
        //         $q->where('kategori_id', $kategoriId);
        //     })
        //     ->latest()
        //     ->get();

        // // Kirimkan $kategori untuk Dropdown DAN $kategoriProduk untuk Grid
        // return view('produk.index', [
        //     'produk' => $produk,
        //     'kategori' => $kategori,             // Digunakan untuk Dropdown Filter
        //     'kategoriProduk' => $kategori,       // Digunakan untuk Komponen Grid
        //     'kategoriId' => $kategoriId,
        // ]);
        $kategoriId = $request->kategori;
        $activeMart = Auth::user()?->activeMart;

        $kategori = KategoriProduk::with(['produk' => function ($q) use ($activeMart) {
            $q->where('is_active', true);

            if ($activeMart) {
                $q->whereHas('marts', function ($m) use ($activeMart) {
                    $m->where('mart.id', $activeMart->id);
                });
            }

            $q->latest();
        }])->get();

        $produk = Produk::where('is_active', true)
            ->when($kategoriId, fn ($q) =>
                $q->where('kategori_id', $kategoriId)
            )
            ->when($activeMart, fn ($q) =>
                $q->whereHas('marts', fn ($m) =>
                    $m->where('mart.id', $activeMart->id)
                )
            )
            ->latest()
            ->get();

        // return view('produk.index', compact(
        //     'produk',
        //     'kategori',
        //     'kategoriId',
        //     'kategoriProduk'    
        // ));
        return view('produk.index', [
            'produk' => $produk,
            'kategori' => $kategori,             // Digunakan untuk Dropdown Filter
            'kategoriProduk' => $kategori,       // Digunakan untuk Komponen Grid
            'kategoriId' => $kategoriId,
        ]);
    }

    // USER: detail produk
    public function show(Produk $produk)
    {
        $activeMart = Auth::user()?->activeMart;

        $produk->load([
            'kategori',
            'marts',
            'variants',
            'reviews',
        ]);

        // Statistik rating
        $ratingStats = ProdukReview::where('produk_id', $produk->id)
            ->selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        $totalReviews = $ratingStats->sum();

        $rekomendasi = Produk::where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->where('is_active', true)
            ->when($activeMart, fn ($q) =>
                $q->whereHas('marts', fn ($m) =>
                    $m->where('mart.id', $activeMart->id)
                )
            )
            ->with('marts')
            ->take(12)
            ->get();

        return view('produk.show', compact(
            'produk',
            'rekomendasi',
            'ratingStats',
            'totalReviews'
        ));
    }

    public function byKategori(KategoriProduk $kategori)
    {
        $produk = Produk::with(['kategori', 'marts'])
            ->where('kategori_id', $kategori->id)
            ->where('is_active', true)
            ->paginate(24);

        return view('produk.by-kategori', compact('kategori', 'produk'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $produk = \App\Models\Produk::where('is_active', true)
            ->where(function ($q) use ($query) {
                // Cari berdasarkan nama produk
                $q->where('nama_produk', 'LIKE', "%{$query}%")
                // ATAU cari berdasarkan nama kategori terkait
                    ->orWhereHas('kategori', function ($k) use ($query) {
                        $k->where('nama_kategori', 'LIKE', "%{$query}%");
                    });
            })
            ->with('marts')
            ->latest()
            ->get();

        return view('produk.search', compact('produk', 'query'));
    }
}
