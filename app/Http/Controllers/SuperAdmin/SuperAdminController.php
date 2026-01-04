<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Mart;
use App\Models\RiwayatPembelian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function index()
    {
        // 1. Total Mart Aktif
        $totalMart = Mart::where('is_active', 1)->count();

        // 2. Total Admin
        $totalAdmin = User::where('role_id', 2)->count();

        // 3. Omzet Global (Total Seluruh Lunas)
        $totalPendapatan = RiwayatPembelian::where('status', 'Lunas')->sum('total_harga');

        // 4. Riwayat Terakhir (Tetap diambil jika ingin ditampilkan di tempat lain, atau bisa dihapus)
        $riwayatTerakhir = RiwayatPembelian::with('user')->latest()->take(5)->get();

        // 5. DATA GRAFIK: Omzet 7 Hari Terakhir
        $grafikOmzet = RiwayatPembelian::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->where('status', 'Lunas')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        // Menyiapkan Label (Tanggal) dan Data (Nominal)
        $labels = $grafikOmzet->pluck('tanggal')->map(function ($date) {
            return date('d M', strtotime($date));
        });
        $totals = $grafikOmzet->pluck('total');

        return view('dashboard.superadmin', compact(
            'totalMart',
            'totalAdmin',
            'totalPendapatan',
            'riwayatTerakhir',
            'labels',
            'totals'
        ));
    }
    // app/Http/Controllers/SuperAdminController.php

    public function manageMart()
    {
        $marts = \App\Models\Mart::all();

        return view('superadmin.mart.index', compact('marts'));
    }

    public function storeMart(Request $request)
    {
        $request->validate([
            'nama_mart' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        \App\Models\Mart::create($request->all());

        return redirect()->back()->with('success', 'Mart berhasil ditambahkan');
    }

    public function updateMart(Request $request, $id)
{
    $request->validate([
        'nama_mart' => 'required|string|max:255',
        'alamat' => 'nullable|string',
    ]);

    $mart = \App\Models\Mart::findOrFail($id);
    $mart->update([
        'nama_mart' => $request->nama_mart,
        'alamat' => $request->alamat,
    ]);

    return redirect()->back()->with('success', 'Data Unit Mart berhasil diperbarui!');
}

    public function toggleMartStatus($id)
    {
        $mart = \App\Models\Mart::findOrFail($id);
        $mart->is_active = ! $mart->is_active;
        $mart->save();

        return redirect()->back()->with('success', 'Status Mart berhasil diubah');
    }
    
}
