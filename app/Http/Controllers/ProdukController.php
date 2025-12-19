<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class ProdukController extends Controller
{
    // USER: list produk
    public function index()
    {
        $produk = Produk::with(['kategori'])
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('produk.show', compact('produk'));
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
            ->limit(4)
            ->get();

        return view('produk.show', compact('produk', 'rekomendasi'));
    }
}
