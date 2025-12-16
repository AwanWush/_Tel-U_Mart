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
        $request->validate([
            'nominal' => 'required|integer',
            'harga' => 'required|integer',
            'metode' => 'required|string',
        ]);

        $tokenCode = $this->generateTokenCode();

        $transaksi = TokenTransaction::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'harga' => $request->harga,
            'token_kode' => $tokenCode,
            'metode_pembayaran' => $request->metode,
            'waktu_transaksi' => now(),
            'status' => 'Berhasil', 
        ]);

        return view('fitur-user.token-result', compact('transaksi'));
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
                    ->orderBy('waktu_transaksi', 'desc')
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

}
