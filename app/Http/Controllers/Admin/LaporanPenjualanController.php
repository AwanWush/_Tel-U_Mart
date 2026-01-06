<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanExport;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil dari request atau default ke bulan & tahun sekarang
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // 🔥 Query dengan filter bulan & tahun + hanya yang LUNAS
        $data = RiwayatPembelian::where('status', 'Lunas')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung ringkasan
        $totalOmset = $data->sum('total_harga');
        $totalTransaksi = $data->count();

        // Normalisasi metode pembayaran (biar Cash, cash, CASH kebaca sama)
        $totalCash = $data->filter(fn($x) => strtolower($x->metode_pembayaran) === 'cash')->sum('total_harga');
        $totalQRIS = $data->filter(fn($x) => strtolower($x->metode_pembayaran) === 'qris')->sum('total_harga');
        $totalMidtrans = $data->filter(fn($x) => strtolower($x->metode_pembayaran) === 'midtrans')->sum('total_harga');
        $totalTransfer = $data->filter(fn($x) => strtolower($x->metode_pembayaran) === 'transfer')->sum('total_harga');
        $totalEwallet = $data->filter(fn($x) => strtolower($x->metode_pembayaran) === 'e-wallet')->sum('total_harga');

        return view('admin.produk.laporan.index', [
            'penjualan' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalOmset' => $totalOmset,
            'totalTransaksi' => $totalTransaksi,
            'totalCash' => $totalCash,
            'totalQRIS' => $totalQRIS,
            'totalMidtrans' => $totalMidtrans,
            'totalTransfer' => $totalTransfer,
            'totalEwallet' => $totalEwallet,
        ]);
    }

    public function export(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        return Excel::download(
            new LaporanPenjualanExport($bulan, $tahun),
            "laporan-penjualan-{$bulan}-{$tahun}.xlsx"
        );
    }
}
