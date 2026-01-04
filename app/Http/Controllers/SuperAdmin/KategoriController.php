<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori global
        $kategori = DB::table('categories')->get();
        return view('superadmin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|unique:categories,nama_kategori']);

        DB::table('categories')->insert([
            'nama_kategori' => $request->nama_kategori,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan secara global.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_kategori' => 'required|string']);

        DB::table('categories')->where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Nama kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();
        return back()->with('success', 'Kategori telah dihapus dari sistem.');
    }
}