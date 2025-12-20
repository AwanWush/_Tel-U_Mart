<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GalonTransaction;

class UserGalonController extends Controller
{
    public function index()
    {
        $punyaGalon = \App\Models\GalonTransaction::where('user_id', Auth::id())
                ->where('nama_galon', 'LIKE', '%Galon Baru%')
                ->where('status', 'Berhasil') // Sesuaikan dengan status transaksi suksesmu
                ->exists();
        $galons = [
            [
                'nama' => 'Galon 19L (Isi Ulang)',
                'harga' => 18000,
                'deskripsi' => 'Galon isi ulang standar 19 liter, cocok untuk dispenser rumah tangga.',
                'gambar' => 'https://cdn-icons-png.flaticon.com/512/4379/4379974.png',
            ],
            [
                'nama' => 'Galon Baru + Isi',
                'harga' => 45000,
                'deskripsi' => 'Galon baru lengkap isi air mineral premium.',
                'gambar' => 'https://cdn-icons-png.flaticon.com/512/4379/4379966.png',
            ],
        ];

        return view('fitur-user.galon', compact('galons', 'punyaGalon'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_galon' => 'required|string',
            'harga_satuan' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        $total = $request->harga_satuan * $request->jumlah;

        $transaksi = GalonTransaction::create([
            'user_id' => Auth::id(),
            'nama_galon' => $request->nama_galon,
            'harga_satuan' => $request->harga_satuan,
            'jumlah' => $request->jumlah,
            'total_harga' => $total,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'waktu_transaksi' => now(),
        ]);

        return view('fitur-user.galon-result', compact('transaksi'));
    }

        public function history()
    {
        $riwayat = GalonTransaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fitur-user.galon-history', compact('riwayat'));
    }

    public function detail($id)
    {
        $transaksi = GalonTransaction::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('fitur-user.galon-detail', compact('transaksi'));
    }

}
