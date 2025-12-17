<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Models\Mart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with(['kategori', 'marts'])
            ->latest()
            ->get();
        $kategori = KategoriProduk::orderBy('id')->get();

        return view('produk.index', compact('produk', 'kategori'));
    }

    public function create()
    {
        // Ambil kategori dari tabel kategori_produk
        $kategori = KategoriProduk::orderBy('id')->get();
        $mart = Mart::all();
        return view('produk.create', compact('kategori', 'mart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'mart_id' => 'required|array',
            'mart_id.*' => 'exists:mart,id',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('mart_id');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        // simpan pivot tanpa harus migrate ulang
        $produk->marts()->sync($request->mart_id);

        return redirect()->route('produk.index')
                        ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::orderBy('id')->get();
        $mart = Mart::all();

        return view('produk.edit', compact('produk', 'kategori', 'mart'));
    }

    public function update(Request $request, Produk $produk)
    {
        // validasi dan update
        $data = $request->except('mart_id');
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }
        $produk->update($data);

        // update pivot mart
        $produk->marts()->sync($request->mart_id);

        // redirect ke halaman kategori
        return redirect()->route('kategori.index')
                        ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Produk $produk)
    {
        $produk->marts()->detach();
        $produk->delete();

        return redirect()->route('kategori.index')
                        ->with('success', 'Produk berhasil dihapus');
    }

}