<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // USER: list produk
    public function index(Request $request)
    {
        $kategoriId = $request->kategori;

        // Ambil data kategori
        $kategori = KategoriProduk::with(['produk' => function ($q) {
            $q->where('is_active', true)->latest();
        }])->get();

        // Query untuk filter
        $produk = Produk::where('is_active', true)
            ->when($kategoriId, function ($q) use ($kategoriId) {
                $q->where('kategori_id', $kategoriId);
            })
            ->latest()
            ->get();

        // Kirimkan $kategori untuk Dropdown DAN $kategoriProduk untuk Grid
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
        $produk->load([
            'kategori',
            'marts',
            'variants',
            'reviews',
        ]);

        $rekomendasi = Produk::where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->where('is_active', true)
            ->take(12)
            ->get();

        return view('produk.show', compact('produk', 'rekomendasi'));
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
