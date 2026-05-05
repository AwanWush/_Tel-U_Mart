<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
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
                $q->select('id', 'name', 'no_telp', 'lokasi_id', 'nomor_kamar');
            },
            'user.lokasi:id,nama_lokasi,nama_gedung',
            'details' => function ($q) {
                // PERBAIKAN nullx: Menggunakan alias qty agar terbaca di aplikasi
                $q->select('id', 'riwayat_pembelian_id', 'nama_produk', 'jumlah', 'jumlah as qty', 'harga_satuan', 'subtotal');
            },
        ])
            ->where(function ($query) use ($driverId) {
                $query->where(function ($q) {
                    $q->where('status_antar', 'diproses')
                        ->whereNull('kurir_id')
                        ->where(function ($subQ) {
                            $subQ->where('tipe_layanan', 'delivery')
                                ->orWhere(function ($galonQ) {
                                    $galonQ->where('tipe_layanan', 'galon')
                                        ->whereIn('id_transaksi', function ($query) {
                                            $query->select(DB::raw("CONCAT('COD-', id)"))
                                                ->from('galon_transactions')
                                                ->where('metode_pengiriman', 'antar');
                                        });
                                });
                        });
                })
                    ->orWhere(function ($q) use ($driverId) {
                        $q->where('status_antar', 'sedang diantar')
                            ->where('kurir_id', $driverId);
                    });
            })
            ->select('id', 'user_id', 'kurir_id', 'id_transaksi', 'total_harga', 'status', 'status_antar', 'tipe_layanan', 'metode_pembayaran', 'alamat_pengantaran', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $alamatDariKolom = $item->alamat_pengantaran ?? null;
                $gedung = $item->user->lokasi->nama_lokasi ?? '-';
                $kamar = $item->user->nomor_kamar ?? '-';
                $alamatDariUser = $gedung.' - Kamar '.$kamar;
                $metodeTercemari = str_contains($item->metode_pembayaran ?? '', 'Gedung')
                                    || str_contains($item->metode_pembayaran ?? '', 'Kamar');
                if ($metodeTercemari) {
                    $item->alamat_display = $alamatDariKolom ?? $item->metode_pembayaran;
                    $item->pembayaran_display = 'Cash / Tunai';
                } else {
                    $item->alamat_display = $alamatDariKolom ?? $alamatDariUser;
                    $item->pembayaran_display = $item->metode_pembayaran;
                }

                return $item;
            });
            \Log::info('CEK PESANAN:', $pesanan->map(function($item) {
    return [
        'id'             => $item->id,
        'alamat_display' => $item->alamat_display ?? 'KOSONG',
        'pembayaran'     => $item->pembayaran_display ?? 'KOSONG',
        'alamat_db'      => $item->alamat_pengantaran ?? 'NULL',
    ];
})->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $pesanan->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_transaksi' => $item->id_transaksi,
                    'total_harga' => $item->total_harga,
                    'status' => $item->status,
                    'status_antar' => $item->status_antar,
                    'tipe_layanan' => $item->tipe_layanan,
                    'metode_pembayaran' => $item->metode_pembayaran,
                    'alamat_display' => $item->alamat_display,
                    'pembayaran_display' => $item->pembayaran_display,
                    'user' => $item->user,
                    'details' => $item->details,
                    'created_at' => $item->created_at,
                ];
            }),
        ]);
    }
    

    public function claim(Request $request, $id)
    {
        $driverId = $request->user()->id;
        $pesanan = RiwayatPembelian::findOrFail($id);

        if (! is_null($pesanan->kurir_id)) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan sudah diklaim driver lain!',
            ], 409);
        }

        if ($pesanan->status_antar !== 'diproses') {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan tidak bisa diklaim.',
            ], 422);
        }

        $pesanan->update([
            'kurir_id' => $driverId,
            'status_antar' => 'sedang diantar',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pesanan berhasil diklaim!',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $driverId = $request->user()->id;
        $pesanan = RiwayatPembelian::findOrFail($id);

        if ($pesanan->kurir_id !== $driverId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pesanan->update([
            'status_antar' => 'selesai',
            'status' => 'Lunas',
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
                'status' => false,
                'message' => 'Pesanan tidak bisa dibatalkan.',
            ], 422);
        }

        $pesanan->update([
            'kurir_id' => null,
            'status_antar' => 'diproses',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pesanan berhasil dibatalkan.',
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Data profil driver',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'nama_bank' => $adminData->nama_bank ?? '-',
                'nomor_rekening' => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji' => $adminData->tanggal_gaji ?? '-',
                'foto_url' => $user->gambar
                                        ? url('storage/'.$user->gambar)
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

        $path = $request->file('foto')->store('profil', 'public');
        $user->gambar = $path;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Foto profil berhasil diperbarui!',
            'foto_url' => url('storage/'.$path),
        ]);
    }

    public function omset(Request $request)
    {
        $user = $request->user();
        $saldo = RiwayatPembelian::where('kurir_id', $user->id)
            ->where('status_antar', 'selesai')
            ->sum('total_harga');

        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'saldo' => $saldo,
                'nama_bank' => $adminData->nama_bank ?? '-',
                'nomor_rekening' => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji' => $adminData
                                        ? Carbon::parse($adminData->tanggal_gaji)->format('d M Y')
                                        : Carbon::now()->format('d M Y'),
            ],
        ]);
    }

    public function riwayat(Request $request)
    {
        $user = $request->user();
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

    public function submitAbsensi(Request $request)
    {
        $user = auth()->user(); // Ambil driver yang login
        $now = Carbon::now('Asia/Jakarta');
        $jam = $now->format('H:i');

        // 1. Validasi QR Code (Gunakan kode statis yang kamu print di tembok)
        if ($request->qr_code !== 'TJT-TELKOM-77') {
            return response()->json(['message' => 'QR Code tidak valid!'], 400);
        }

        // 2. Cek Batas Waktu Kadaluarsa (Jam 08:00)
        if ($now->greaterThan(Carbon::createFromTimeString('08:00'))) {
            return response()->json(['message' => 'QR sudah kadaluarsa (Batas jam 08:00)!'], 403);
        }

        // 3. Tentukan Status (Tepat Waktu atau Terlambat)
        $status = 'Tepat Waktu';
        if ($now->greaterThan(Carbon::createFromTimeString('07:00'))) {
            $status = 'Terlambat';
        }

        // 4. Simpan ke Database
        $absensi = Absensi::updateOrCreate(
            ['user_id' => $user->id, 'created_at' => $now->toDateString()],
            [
                'jam_masuk' => $now->toDateTimeString(),
                'status' => $status,
                'koordinat_absen' => $request->lat.','.$request->lng,
            ]
        );

        return response()->json([
            'message' => 'Absensi berhasil!',
            'status' => $status,
            'jam' => $jam,
        ]);
    }

    public function submitCheckout(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');

        // Validasi jam pulang minimal jam 15:00
        if ($now->hour < 15) {
            return response()->json(['message' => 'Belum jam pulang (Minimal jam 15:00)!'], 403);
        }

        $absensi = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($absensi) {
            $absensi->update(['jam_pulang' => $now->toDateTimeString()]);

            return response()->json(['message' => 'Berhasil Checkout. Hati-hati di jalan!']);
        }

        return response()->json(['message' => 'Data absen masuk tidak ditemukan hari ini.'], 404);
    }
}
