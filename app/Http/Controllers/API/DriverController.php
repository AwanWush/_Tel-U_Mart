<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $driverId = $request->user()->id;

        $pesanan = RiwayatPembelian::with([
            'user' => function ($q) {
                $q->select('id', 'name', 'no_telp', 'lokasi_id');
            },
            'user.lokasi:id,nama_lokasi,nama_gedung',
            'details' => function ($q) {
                $q->select('id', 'riwayat_pembelian_id', 'nama_produk', 'jumlah', 'harga_satuan', 'subtotal');
            },
        ])
            ->where(function ($query) use ($driverId) {
                $query->where(function ($q) {
                    $q->where('status_antar', 'diproses')
                        ->whereNull('kurir_id')
                        ->where('tipe_layanan', 'delivery');
                })
                    ->orWhere(function ($q) use ($driverId) {
                        $q->where('status_antar', 'sedang diantar')
                            ->where('kurir_id', $driverId);
                    });
            })
            ->select('id', 'user_id', 'kurir_id', 'id_transaksi', 'total_harga', 'status', 'status_antar', 'tipe_layanan', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $pesanan,
        ]);
    }

    public function claim(Request $request, $id)
    {
        $driverId = $request->user()->id;
        $pesanan  = RiwayatPembelian::findOrFail($id);

        if (! is_null($pesanan->kurir_id)) {
            return response()->json([
                'status'  => false,
                'message' => 'Pesanan sudah diklaim driver lain!',
            ], 409);
        }

        if ($pesanan->status_antar !== 'diproses') {
            return response()->json([
                'status'  => false,
                'message' => 'Pesanan tidak bisa diklaim.',
            ], 422);
        }

        $pesanan->update([
            'kurir_id'     => $driverId,
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
        $pesanan  = RiwayatPembelian::findOrFail($id);

        if ($pesanan->kurir_id !== $driverId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pesanan->update([
            'status_antar' => 'selesai',
            'status'       => 'Lunas',
        ]);

        return response()->json(['message' => 'Pesanan berhasil diselesaikan!']);
    }

    // Batalkan pesanan yang sedang diantar (kembalikan ke antrian)
    public function batalkan(Request $request, $id)
    {
        $driverId = $request->user()->id;

        $pesanan = RiwayatPembelian::findOrFail($id);

        if ($pesanan->kurir_id !== $driverId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($pesanan->status_antar !== 'sedang diantar') {
            return response()->json([
                'status'  => false,
                'message' => 'Pesanan tidak bisa dibatalkan.',
            ], 422);
        }

        $pesanan->update([
            'kurir_id'     => null,
            'status_antar' => 'diproses',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Pesanan berhasil dibatalkan.',
        ]);
    }

    public function profile(Request $request)
    {
        $user      = $request->user();
        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status'  => true,
            'message' => 'Data profil driver',
            'data'    => [
                'id'             => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'no_telp'        => $user->no_telp,
                'nama_bank'      => $adminData->nama_bank      ?? '-',
                'nomor_rekening' => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji'   => $adminData->tanggal_gaji   ?? '-',
                'foto_url'       => $user->gambar
                                        ? url('storage/' . $user->gambar)
                                        : null,
            ],
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
            Storage::disk('public')->delete($user->gambar);
        }

        $path         = $request->file('foto')->store('profil', 'public');
        $user->gambar = $path;
        $user->save();

        return response()->json([
            'status'   => true,
            'message'  => 'Foto profil berhasil diperbarui!',
            'foto_url' => url('storage/' . $path),
        ]);
    }

    public function omset(Request $request)
    {
        $user  = $request->user();
        $saldo = RiwayatPembelian::where('kurir_id', $user->id)
            ->where('status_antar', 'selesai')
            ->sum('total_harga');

        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'saldo'          => $saldo,
                'nama_bank'      => $adminData->nama_bank      ?? '-',
                'nomor_rekening' => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji'   => $adminData
                                        ? Carbon::parse($adminData->tanggal_gaji)->format('d M Y')
                                        : Carbon::now()->format('d M Y'),
            ],
        ]);
    }

    public function riwayat(Request $request)
    {
        $user    = $request->user();
        $riwayat = RiwayatPembelian::with([
            'user:id,name',
            'details:id,riwayat_pembelian_id,nama_produk,jumlah,subtotal',
        ])
            ->where('kurir_id', $user->id)
            ->where('status_antar', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->select('id', 'user_id', 'total_harga', 'status_antar', 'updated_at')
            ->get();

        return response()->json(['status' => 'success', 'data' => $riwayat]);
    }
}