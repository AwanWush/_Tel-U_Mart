<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Mart;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with(['kategori', 'marts'])->latest()->get();
        $kategori = KategoriProduk::all();

        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    // ================= CREATE =================
    public function create()
    {
        $kategori = KategoriProduk::all();
        $mart = Mart::all();

        return view('admin.produk.create', compact('kategori', 'mart'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produk,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'mart_id' => 'required|array',
            'status_ketersediaan' => 'required|in:Tersedia,Habis',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('mart_id');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // ⬇️ SIMPAN KE public/produk_assets
            $file->move(public_path('produk_assets'), $filename);

            // simpan path relatif ke DB
            $data['gambar'] = 'produk_assets/' . $filename;
        }

        $produk = Produk::create($data);
        $produk->marts()->sync($request->mart_id);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::all();
        $mart = Mart::all();

        return view('admin.produk.edit', compact('produk', 'kategori', 'mart'));
    }

    // ================= UPDATE =================
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'mart_id' => 'required|array',
            'status_ketersediaan' => 'required|in:Tersedia,Habis',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('mart_id');

        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('produk_assets'), $filename);

            $data['gambar'] = 'produk_assets/' . $filename;
        }

        $produk->update($data);
        $produk->marts()->sync($request->mart_id);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    // ================= DELETE =================
    public function destroy(Produk $produk)
    {
        // hapus gambar
        if ($produk->gambar && file_exists(public_path($produk->gambar))) {
            unlink(public_path($produk->gambar));
        }

        $produk->marts()->detach();
        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
