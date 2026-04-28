<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $driverId = $request->user()->id;

        // FIX: Wrap setiap kondisi orWhere dalam closure agar SQL-nya benar
        $pesanan = RiwayatPembelian::with(['user', 'user.lokasi', 'details'])
            ->where(function ($query) use ($driverId) {
                // Kondisi 1: Pesanan baru — belum ada kurir, tipe delivery, status diproses
                $query->where(function ($q) {
                    $q->where('status_antar', 'diproses')
                      ->whereNull('kurir_id')
                      ->where('tipe_layanan', 'delivery');
                })
                // Kondisi 2: Pesanan milik driver ini yang sedang diantar
                ->orWhere(function ($q) use ($driverId) {
                    $q->where('status_antar', 'sedang diantar')
                      ->where('kurir_id', $driverId);
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pesanan,
        ]);
    }

    public function claim(Request $request, $id)
    {
        $driverId = $request->user()->id;

        $pesanan = RiwayatPembelian::findOrFail($id);

        // FIX: Cegah race condition — pastikan belum diklaim driver lain
        if (!is_null($pesanan->kurir_id)) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan sudah diklaim driver lain!',
            ], 409);
        }

        // FIX: Pastikan hanya pesanan berstatus diproses yang bisa diklaim
        if ($pesanan->status_antar !== 'diproses') {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan tidak bisa diklaim.',
            ], 422);
        }

        $pesanan->update([
            'kurir_id'    => $driverId,
            'status_antar' => 'sedang diantar',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pesanan berhasil diklaim!',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $driverId = $request->user()->id;

        $pesanan = RiwayatPembelian::findOrFail($id);

        // FIX: Pastikan hanya kurir pemilik pesanan yang bisa selesaikan
        if ($pesanan->kurir_id !== $driverId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pesanan->update([
            'status_antar' => 'selesai',
            'status'       => 'Lunas',   // opsional: tandai juga lunas
        ]);

        return response()->json(['message' => 'Pesanan berhasil diselesaikan!']);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        // FIX: Ambil data rekening dari tabel admins, bukan dari no_telp
        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status'  => true,
            'message' => 'Data profil driver',
            'data'    => [
                'id'              => $user->id,
                'name'            => $user->name,
                'email'           => $user->email,
                'no_telp'         => $user->no_telp,
                'nama_bank'       => $adminData->nama_bank ?? '-',
                'nomor_rekening'  => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji'    => $adminData->tanggal_gaji ?? '-',
            ],
        ]);
    }

    public function omset(Request $request)
    {
        $user = $request->user();

        $saldo = RiwayatPembelian::where('kurir_id', $user->id)
            ->where('status_antar', 'selesai')
            ->sum('total_harga');

        // FIX: Ambil nama_bank, nomor_rekening, tanggal_gaji dari tabel admins
        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'saldo'           => $saldo,
                'nama_bank'       => $adminData->nama_bank ?? '-',
                'nomor_rekening'  => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji'    => $adminData
                                     ? Carbon::parse($adminData->tanggal_gaji)->format('d M Y')
                                     : Carbon::now()->format('d M Y'),
            ],
        ]);
    }

    public function riwayat(Request $request)
    {
        $user = $request->user();

        $riwayat = RiwayatPembelian::with(['user', 'details'])
            ->where('kurir_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $riwayat,
        ]);
    }
}