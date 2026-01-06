<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanExport;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $martId = Auth::user()->mart_id;

        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $query = RiwayatPembelian::where('status', 'Lunas')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun);

        // Kalau tabel ini punya mart_id:
        // ->where('mart_id', $martId);

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('admin.produk.laporan.index', [
            'penjualan' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalOmset' => $data->sum('total_harga'),
            'totalTransaksi' => $data->count(),
            'totalCash' => $data->where('metode_pembayaran', 'Cash')->sum('total_harga'),
            'totalQRIS' => $data->where('metode_pembayaran', 'QRIS')->sum('total_harga'),
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
