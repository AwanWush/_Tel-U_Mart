<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPembelian;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        // Mengambil data riwayat milik user login dengan relasi detail produk
        $riwayat = RiwayatPembelian::with('details')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('riwayat.index', compact('riwayat'));
    }
}