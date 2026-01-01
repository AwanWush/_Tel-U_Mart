<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GalonTransaction;
use App\Helpers\NotificationHelper;
use App\Models\RiwayatPembelian;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\Log;

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
            'metode_pembayaran' => 'COD',
        ]);

        $riwayat = RiwayatPembelian::create([
            'user_id' => Auth::id(),
            'id_transaksi' => 'COD-' . $transaksi->id,
            'total_harga' => $total,
            'status' => 'Belum Dibayar',
            'status_antar' => 'diproses',
            'metode_pembayaran' => 'COD',
            'tipe_layanan' => 'galon',
        ]);

        DetailPembelian::create([
            'riwayat_pembelian_id' => $riwayat->id,
            'nama_produk' => 'Galon - ' . $request->nama_galon,
            'harga_satuan' => $request->harga_satuan,
            'jumlah' => $request->jumlah,
            'subtotal' => $total,
        ]);

        NotificationHelper::send(
            Auth::user(),
            'galon',
            'Pesanan Galon COD 🚰',
            "Pesanan galon {$request->nama_galon} menunggu pembayaran COD.",
            $riwayat
        );

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

    public function result($id)
    {
        $transaksi = GalonTransaction::findOrFail($id);

        return view('fitur-user.galon-result', compact('transaksi'));
    }

    public function storeMidtrans(Request $request)
    {
        $request->validate([
            'nama_galon' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer',
            'total_harga' => 'required|integer',
            'order_id' => 'required|string',
            'status' => 'required|in:paid,pending',
        ]);

        try {
            $transaksi = GalonTransaction::create([
                'user_id' => Auth::id(),
                'nama_galon' => $request->nama_galon,
                'jumlah' => $request->jumlah,
                'harga_satuan' => $request->harga_satuan,
                'total_harga' => $request->total_harga,
                'order_id' => $request->order_id,
                'status' => $request->status === 'pending' ? 'pending' : 'paid',
                'metode_pembayaran' => 'MIDTRANS',
                'waktu_transaksi' => now(),
            ]);
    
            // $riwayat = RiwayatPembelian::create([
            //     'user_id' => Auth::id(),
            //     'id_transaksi' => $transaksi->order_id,
            //     'total_harga' => $transaksi->total_harga,
            //     'status' => $transaksi->status === 'paid' ? 'Lunas' : 'Menunggu Pembayaran',
            //     'status_antar' => 'diproses',
            //     'metode_pembayaran' => 'MIDTRANS',
            //     'tipe_layanan' => 'galon',
            // ]);
            $riwayat = RiwayatPembelian::create([
                'user_id' => Auth::id(),
                'id_transaksi' => $request->order_id,
                'total_harga' => $request->total_harga,
                'status' => $request->status === 'paid' ? 'Lunas' : 'Menunggu Pembayaran',
                'status_antar' => 'diproses',
                'metode_pembayaran' => 'MIDTRANS',
                'tipe_layanan' => 'galon',
            ]);
    
            // DetailPembelian::create([
            //     'riwayat_pembelian_id' => $riwayat->id,
            //     'nama_produk' => 'Galon - ' . $transaksi->nama_galon,
            //     'harga_satuan' => $transaksi->harga_satuan,
            //     'jumlah' => $transaksi->jumlah,
            //     'subtotal' => $transaksi->total_harga,
            // ]);
            DetailPembelian::create([
                'riwayat_pembelian_id' => $riwayat->id,
                'nama_produk' => 'Galon - ' . $request->nama_galon,
                'harga_satuan' => $request->harga_satuan,
                'jumlah' => $request->jumlah,
                'subtotal' => $request->total_harga,
            ]);
    
            // NotificationHelper::send(
            //     Auth::user(),
            //     'galon',
            //     $transaksi->status === 'paid'
            //         ? 'Pesanan Galon Berhasil 🚰'
            //         : 'Pesanan Galon Menunggu Pembayaran ⏳',
            //     "Pesanan {$transaksi->nama_galon} ({$transaksi->jumlah} galon).",
            //     $riwayat
            // );
            NotificationHelper::send(
                Auth::user(),
                'galon',
                $request->status === 'paid'
                    ? 'Pesanan Galon Berhasil 🚰'
                    : 'Pesanan Galon Menunggu Pembayaran ⏳',
                "Pesanan {$request->nama_galon} ({$request->jumlah} galon).",
                $riwayat
            );

            return response()->json(['id' => $transaksi->id]);

        } catch (\Throwable $e) {
            \Log::error('STORE MIDTRANS ERROR: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal menyimpan transaksi'
            ], 500);
        }

    }
}
