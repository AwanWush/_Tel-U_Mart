<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $martId = Auth::user()->mart_id;

        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $penjualan = Penjualan::where('mart_id', $martId)
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        return view('admin.produk.laporan.index', [
            'penjualan' => $penjualan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalOmset' => $penjualan->sum('total'),
            'totalTransaksi' => $penjualan->count(),
            'totalCash' => $penjualan->where('metode_pembayaran', 'Cash')->sum('total'),
            'totalQRIS' => $penjualan->where('metode_pembayaran', 'QRIS')->sum('total'),
        ]);
    }
}
