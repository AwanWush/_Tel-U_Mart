<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Models\Produk;         

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::orderBy('id')->get();
        $produk = Produk::with(['kategori', 'marts'])
        ->latest()
        ->get();
    
        $mart = \App\Models\Mart::orderBy('id')->get();

        return view('kategori.index', compact('kategori', 'produk', 'mart'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_produk,nama_kategori'
        ]);

        KategoriProduk::create($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(KategoriProduk $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }
public function update(Request $request, KategoriProduk $kategori)
{
    $request->validate([
        'nama_kategori' => 'required|unique:kategori_produk,nama_kategori,' . $kategori->id
    ]);

    $kategori->update($request->only('nama_kategori'));

    return redirect()->route('kategori.index')
                     ->with('success', 'Kategori berhasil diperbarui');
}

public function destroy(KategoriProduk $kategori)
{
    if ($kategori->produk()->count() > 0) {
        return back()->with('error', 'Kategori masih digunakan produk');
    }

    $kategori->delete();
    return redirect()->route('kategori.index')
                     ->with('success', 'Kategori berhasil dihapus');
}

}
