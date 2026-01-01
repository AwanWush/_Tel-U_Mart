<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenTransaction;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPembelian;
use App\Models\DetailPembelian;

class UserTokenController extends Controller
{
    public function index()
    {
        $tokens = [
            ['nominal' => 20000, 'harga' => 20500],
            ['nominal' => 50000, 'harga' => 51000],
            ['nominal' => 100000, 'harga' => 101000],
            ['nominal' => 200000, 'harga' => 201000],
        ];

        return view('fitur-user.token', compact('tokens'));
    }

    public function store(Request $request)
    {
        // $tokenCode = $this->generateTokenCode();

        // $transaksi = TokenTransaction::create([
        //     'user_id' => Auth::id(),
        //     'gedung' => Auth::user()->lokasi->nama_lokasi ?? '-',
        //     'kamar' => Auth::user()->nomor_kamar ?? '-',
        //     'nama_penghuni' => Auth::user()->name,
        //     'nomor_hp' => Auth::user()->no_hp,
        //     'nominal' => $request->nominal,
        //     'total_harga' => $request->harga,
        //     'kode_token' => $tokenCode,
        //     'metode' => $request->metode,
        //     'status' => 'Berhasil',
        // ]);
        $transaksi = TokenTransaction::findOrFail($request->transaction_id);

        $tokenCode = $this->generateTokenCode();

        $transaksi->update([
            'kode_token' => $tokenCode,
            'status' => 'Berhasil',
            'metode' => $request->metode,
        ]);

        // $riwayat = RiwayatPembelian::create([
        //     'user_id' => Auth::id(),
        //     'id_transaksi' => 'TOKEN-' . now()->timestamp,
        //     'total_harga' => $request->harga,
        //     'status' => 'Lunas',
        //     'status_antar' => 'selesai', // token langsung selesai
        //     'metode_pembayaran' => strtoupper($request->metode),
        //     'tipe_layanan' => 'token',
        // ]);
        // $riwayat = RiwayatPembelian::create([
        //     'user_id' => Auth::id(),
        //     'id_transaksi' => $request->order_id,
        //     'total_harga' => $request->harga,
        //     'status' => 'Lunas',
        //     'metode_pembayaran' => 'MIDTRANS',
        //     'tipe_layanan' => 'token',
        // ]);
        $riwayat = RiwayatPembelian::firstOrCreate(
            ['id_transaksi' => $request->order_id],
            [
                'user_id' => Auth::id(),
                'total_harga' => $transaksi->total_harga,
                'status' => 'Lunas',
                'metode_pembayaran' => 'MIDTRANS',
                'tipe_layanan' => 'token',
            ]
        );

        DetailPembelian::create([
            'riwayat_pembelian_id' => $riwayat->id,
            'nama_produk' => 'Token Listrik',
            'keterangan' => 'Nomor Token: ' . $tokenCode,
            'harga_satuan' => $request->nominal,
            'jumlah' => 1,
            'subtotal' => $request->harga,
        ]);

        // ✅ KIRIM NOTIFIKASI TOKEN
        // NotificationHelper::send(
        //     Auth::user(),
        //     'token',
        //     'Token Listrik Berhasil ⚡',
        //     'Pembelian token listrik Rp ' . number_format($request->nominal, 0, ',', '.') . ' berhasil.',
        //     null
        // );
        NotificationHelper::send(
            Auth::user(),
            'token',
            'Token Listrik Berhasil ⚡',
            'Pesanan token listrik dengan ID ' . $request->order_id .
            ' Pembelian token listrik Rp ' . number_format($request->nominal, 0, ',', '.') . ' berhasil.',
            $riwayat
        );

        return response()->json([
            'id' => $transaksi->id
        ]);
    }


    private function generateTokenCode()
    {
        $result = '';
        for ($i = 0; $i < 16; $i++) {
            $result .= rand(0, 9);
        }
        return trim(chunk_split($result, 4, ' '));
    }

    public function history()
    {
        $riwayat = TokenTransaction::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('fitur-user.token-history', compact('riwayat'));
    }

    public function detail($id)
    {
        $transaksi = TokenTransaction::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        return view('fitur-user.token-detail', compact('transaksi'));
    }

    public function result($id)
    {
        $transaksi = TokenTransaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('fitur-user.token-result', [
            'nomor_token' => $transaksi->kode_token,
            'amount' => $transaksi->nominal
        ]);
    }
}
