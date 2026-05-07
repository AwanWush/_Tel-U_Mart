<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OrderUpdateMail;
use App\Models\Absensi;
use App\Models\RiwayatPembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
                    $alamatDisplay = $alamatDariKolom ?? $item->metode_pembayaran;
                    $pembayaranDisplay = 'Cash / Tunai';
                } else {
                    $alamatDisplay = $alamatDariKolom ?? $alamatDariUser;
                    $pembayaranDisplay = $item->metode_pembayaran;
                }

                return [
                    'id' => $item->id,
                    'id_transaksi' => $item->id_transaksi,
                    'total_harga' => $item->total_harga,
                    'status' => $item->status,
                    'status_antar' => $item->status_antar,
                    'kurir_id' => $item->kurir_id,
                    'tipe_layanan' => $item->tipe_layanan,
                    'kurir_id' => $item->kurir_id,
                    'metode_pembayaran' => $item->metode_pembayaran,
                    'alamat_display' => $alamatDisplay,
                    'pembayaran_display' => $pembayaranDisplay,
                    'user' => $item->user,
                    'details' => $item->details,
                    'created_at' => $item->created_at,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $pesanan,
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

        $pesanan->load(['user', 'details']);
        if ($pesanan->user && $pesanan->user->email) {
            Mail::to($pesanan->user->email)->send(
                new OrderUpdateMail($pesanan, '🛵 Pesanan Anda Sedang Diantar - TJ-T Mart')
            );
        }

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

        $pesanan->load(['user', 'details']);
        if ($pesanan->user && $pesanan->user->email) {
            Mail::to($pesanan->user->email)->send(
                new OrderUpdateMail($pesanan, '✅ Pesanan Anda Selesai - TJ-T Mart')
            );
        }

        return response()->json(['message' => 'Pesanan berhasil diselesaikan!']);
    }

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
            'status_antar' => 'dibatalkan',
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
            ->whereIn('status_antar', ['selesai', 'dibatalkan'])
            ->orderBy('updated_at', 'desc')
            ->select('id', 'user_id', 'total_harga', 'status_antar', 'updated_at')
            ->get();

        return response()->json(['status' => 'success', 'data' => $riwayat]);
    }

    public function submitAbsensi(Request $request)
    {
        $user = auth()->user();
        $now = Carbon::now('Asia/Jakarta');
        $jamMenit = $now->format('H:i');

        // 1. Cek Duplikasi (Sudah ada di kodemu, pertahankan)
        $absenHariIni = Absensi::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($absenHariIni) {
            return response()->json(['status' => 'error', 'message' => 'Kamu sudah absen hari ini!'], 200);
        }

        // 2. KUNCI RENTANG WAKTU (Harus antara 06:30 sampai 08:00)
        if ($jamMenit < '06:30' || $jamMenit > '08:00') {
            return response()->json([
                'status' => 'error',
                'message' => 'Absensi Gagal! Sesi absen masuk hanya dibuka jam 06:30 - 08:00 WIB.',
            ], 200);
        }

        // 3. Tentukan Status Berdasarkan Jam
        if ($jamMenit <= '07:00') {
            $status = 'Tepat Waktu';
        } else {
            $status = 'Terlambat';
        }

        // 4. Simpan
        Absensi::create([
            'user_id' => $user->id,
            'jam_masuk' => $now->toDateTimeString(),
            'status' => $status,
            'koordinat_absen' => $request->koordinat,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Check-in: '.$status,
            'jam' => $jamMenit,
        ]);
    }

    public function submitCheckout(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');
        $jamMenit = $now->format('H:i');

        // 1. Validasi Rentang Waktu Checkout (15:00 - 23:00)
        if ($jamMenit < '15:00' || $jamMenit > '23:00') {
            return response()->json([
                'status' => 'error',
                'message' => 'Checkout Gagal! Sesi absen pulang hanya dibuka jam 15:00 - 23:00 WIB.',
            ], 200);
        }

        // 2. Cari data absen driver untuk hari ini
        $absensi = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->first();

        // 3. Cek apakah Driver sudah absen masuk pagi tadi
        if (! $absensi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu tidak bisa checkout karena hari ini kamu tidak absen masuk',
            ], 200);
        }

        // 4. Cek apakah sudah pernah checkout sebelumnya
        if ($absensi->jam_pulang != null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu sudah melakukan checkout sebelumnya hari ini',
            ], 200);
        }

        // 5. Update data pulang
        $absensi->update([
            'jam_pulang' => $now->toDateTimeString(),
            'koordinat_absen' => $request->koordinat,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Checkout. Hati-hati di jalan, Adit!',
        ]);
    }

    public function updateStatusAntar(Request $request, $id)
    {
        $driverId = $request->user()->id;
        $pesanan = RiwayatPembelian::with(['user', 'details'])->findOrFail($id);

        if ($pesanan->kurir_id !== $driverId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pesanan->update(['status_antar' => 'tiba']);

        if ($pesanan->user && $pesanan->user->email) {
            Mail::to($pesanan->user->email)->send(
                new OrderUpdateMail($pesanan, '📦 Pesanan Anda Telah Tiba - TJ-T Mart')
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Pesanan tiba dan email terkirim!',
        ]);
    }
}
