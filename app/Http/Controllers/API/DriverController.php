<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function index()
    {
        $pesanan = RiwayatPembelian::with('user')
            ->where('status_antar', 'diproses')
            ->orWhere('status_antar', 'sedang diantar')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ]);
    }

    public function claim(Request $request, $id)
    {
        $pesanan = RiwayatPembelian::findOrFail($id);

        $pesanan->update([
            'kurir_id'    => $request->user()->id,
            'status_antar' => 'sedang diantar'
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pesanan berhasil diklaim!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = RiwayatPembelian::findOrFail($id);
        $pesanan->update(['status_antar' => 'selesai']);

        return response()->json(['message' => 'Pesanan berhasil diselesaikan!']);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status'  => true,
            'message' => 'Data profil driver',
            'data'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    // ─── Omset: saldo = total pesanan selesai milik kurir ini ───
    public function omset(Request $request)
    {
        $user = $request->user();

        $saldo = RiwayatPembelian::where('kurir_id', $user->id)
            ->where('status_antar', 'selesai')
            ->sum('total_harga');

        $tanggalGaji = Carbon::now()->format('d M Y');

        return response()->json([
            'status' => 'success',
            'data' => [
                'saldo'          => $saldo,
                'nama_bank'      => $user->mart_id ? 'BCA' : '-',
                'nomor_rekening' => $user->no_telp ?? '-',
                'tanggal_gaji'   => $tanggalGaji,
            ]
        ]);
    }

    // ─── Riwayat: pesanan yang sudah pernah ditangani kurir ini ───
    public function riwayat(Request $request)
    {
        $user = $request->user();

        $riwayat = RiwayatPembelian::with('user')
            ->where('kurir_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $riwayat
        ]);
    }
}