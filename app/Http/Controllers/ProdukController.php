<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Models\Mart;
use App\Models\KategoriProduk;

class ProdukController extends Controller
{
    // USER: list produk
    public function index()
    {
        $produk = Produk::with(['kategori', 'marts'])
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('produk.index', compact('produk'));
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
}
