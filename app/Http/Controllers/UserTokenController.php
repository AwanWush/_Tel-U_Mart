<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenTransaction;
use Illuminate\Support\Facades\Auth;

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
        $tokenCode = $this->generateTokenCode();

        $transaksi = TokenTransaction::create([
            'user_id' => Auth::id(),
            'gedung' => Auth::user()->lokasi->nama_lokasi ?? '-',
            'kamar' => Auth::user()->nomor_kamar ?? '-',
            'nama_penghuni' => Auth::user()->name,
            'nomor_hp' => Auth::user()->no_hp,
            'nominal' => $request->nominal,
            'total_harga' => $request->harga,
            'kode_token' => $tokenCode,
            'metode' => $request->metode,
            'status' => 'Berhasil',
        ]);

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
