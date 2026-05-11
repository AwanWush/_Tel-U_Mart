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
                $q->select('id', 'name', 'no_telp', 'lokasi_id', 'nomor_kamar', 'gambar');
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
            ->take(20)
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

                $details = $item->details->map(function ($d) {
                    $foto = \DB::table('produk')
                        ->where('nama_produk', $d->nama_produk)
                        ->value('gambar');

                    return [
                        'id' => $d->id,
                        'nama_produk' => $d->nama_produk,
                        'jumlah' => $d->jumlah,
                        'qty' => $d->jumlah,
                        'harga_satuan' => $d->harga_satuan,
                        'subtotal' => $d->subtotal,
                        'foto_produk' => $foto ?? null,
                    ];
                });

                return [
                    'id' => $item->id,
                    'id_transaksi' => $item->id_transaksi,
                    'total_harga' => $item->total_harga,
                    'status' => $item->status,
                    'status_antar' => $item->status_antar,
                    'kurir_id' => $item->kurir_id,
                    'tipe_layanan' => $item->tipe_layanan,
                    'metode_pembayaran' => $item->metode_pembayaran,
                    'alamat_display' => $alamatDisplay,
                    'pembayaran_display' => $pembayaranDisplay,
                    'user' => $item->user,
                    'details' => $details,
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

        $pesanan->load(['user', 'details.produk']);
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

        $ongkirDriver = ($pesanan->tipe_layanan === 'delivery' || $pesanan->tipe_layanan === 'galon') ? 3000 : 0;

        $pesanan->update([
            'status_antar' => 'selesai',
            'status' => 'Lunas',
            'ongkir_driver' => $ongkirDriver,
        ]);

        $pesanan->load(['user', 'details.produk']);
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

        $pesanan->update(['status_antar' => 'dibatalkan']);

        return response()->json([
            'status' => true,
            'message' => 'Pesanan berhasil dibatalkan.',
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        $sudahAbsen = DB::table('absensis')
            ->where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('jam_masuk')
            ->exists();

        return response()->json([
            'status' => true,
            'message' => 'Data profil driver',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'status_akun' => $user->status,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'nama_bank' => $adminData->nama_bank ?? '-',
                'nomor_rekening' => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji' => $adminData->tanggal_gaji ?? '-',
                'foto_url' => $user->gambar ? url('storage/'.$user->gambar) : null,
                'is_absen_hari_ini' => $sudahAbsen,
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

        // Saldo total semua waktu (untuk halaman Omset — tidak berubah)
        $saldo = RiwayatPembelian::where('kurir_id', $user->id)
            ->whereIn('status_antar', ['selesai', 'Selesai', 'tiba', 'Tiba'])
            ->sum('ongkir_driver');

        // Saldo hari ini saja (untuk halaman Beranda)
        $saldoHariIni = RiwayatPembelian::where('kurir_id', $user->id)
            ->whereIn('status_antar', ['selesai', 'Selesai', 'tiba', 'Tiba'])
            ->where('ongkir_driver', '>', 0)
            ->whereDate('updated_at', Carbon::today())
            ->sum('ongkir_driver');

        $pesananHariIni = RiwayatPembelian::where('kurir_id', $user->id)
            ->whereIn('status_antar', ['selesai', 'Selesai', 'tiba', 'Tiba'])
            ->where('ongkir_driver', '>', 0)
            ->whereDate('updated_at', Carbon::today())
            ->count();

        $adminData = DB::table('admins')->where('user_id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'saldo' => $saldo,
                'saldo_hari_ini' => $saldoHariIni,
                'pesanan_hari_ini' => $pesananHariIni,
                'nama_bank' => $adminData->nama_bank ?? '-',
                'nomor_rekening' => $adminData->nomor_rekening ?? '-',
                'tanggal_gaji' => Carbon::now()->format('d M Y'),
            ],
        ]);
    }

    public function riwayat(Request $request)
    {
        $user = $request->user();

        // Koordinat per mart
        $martKoordinat = [
            1 => ['lat' => -6.971204472034136, 'lng' => 107.62863290561009, 'nama' => 'TJ Mart Putra'],
            2 => ['lat' => -6.970040951360206, 'lng' => 107.6271015587333,  'nama' => 'T Mart Putra'],
            3 => ['lat' => -6.974471953604368, 'lng' => 107.62890391051174, 'nama' => 'TJ Mart Putri'],
        ];

        $riwayat = RiwayatPembelian::with([
            'user' => function ($q) {
                $q->select('id', 'name', 'gambar', 'lokasi_id', 'nomor_kamar', 'alamat_gedung');
            },
            'user.lokasi:id,nama_lokasi,nama_gedung,latitude,longitude,mart_id',
            'details:id,riwayat_pembelian_id,nama_produk,jumlah,subtotal',
        ])
            ->where('kurir_id', $user->id)
            ->whereIn('status_antar', ['selesai', 'Selesai', 'tiba', 'Tiba', 'dibatalkan']) // ← FIX: tambah kapital
            ->orderBy('updated_at', 'desc')
            ->select('id', 'user_id', 'total_harga', 'status_antar', 'created_at', 'updated_at', 'alamat_pengantaran', 'metode_pembayaran')
            ->get()
            ->map(function ($item) use ($martKoordinat) {
                $alamatDariKolom = $item->alamat_pengantaran ?? null;
                $gedung = $item->user->lokasi->nama_lokasi ?? $item->user->alamat_gedung ?? '-';
                $kamar = $item->user->nomor_kamar ?? '-';
                $alamatDariUser = $gedung.' - Kamar '.$kamar;
                $metodeTercemari = str_contains($item->metode_pembayaran ?? '', 'Gedung')
                                || str_contains($item->metode_pembayaran ?? '', 'Kamar');

                $alamatDisplay = $metodeTercemari
                    ? ($alamatDariKolom ?? $item->metode_pembayaran)
                    : ($alamatDariKolom ?? $alamatDariUser);

                // Nama mart & hitung jarak
                $martId = $item->user->lokasi->mart_id ?? null;
                $namaMart = $martKoordinat[$martId]['nama'] ?? 'TJ Mart Putri';
                $jarakText = '- m';
                $durasiText = '- menit';

                $lat = $item->user->lokasi->latitude ?? null;
                $lng = $item->user->lokasi->longitude ?? null;

                if ($lat && $lng && $martId && isset($martKoordinat[$martId])) {
                    $martLat = $martKoordinat[$martId]['lat'];
                    $martLng = $martKoordinat[$martId]['lng'];
                    $jarakMeter = $this->hitungJarak($martLat, $martLng, $lat, $lng);
                    $jarakText = $jarakMeter < 1000
                        ? round($jarakMeter).' m'
                        : round($jarakMeter / 1000, 1).' km';
                    $durasiMenit = max(1, round($jarakMeter / 200));
                    $durasiText = $durasiMenit.' menit';
                }

                return [
                    'id' => $item->id,
                    'total_harga' => $item->total_harga,
                    'status_antar' => $item->status_antar,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'alamat_display' => $alamatDisplay,
                    'nama_mart' => $namaMart,
                    'jarak' => $jarakText,
                    'durasi' => $durasiText,
                    'user' => $item->user,
                    'details' => $item->details,
                ];
            });

        return response()->json(['status' => 'success', 'data' => $riwayat]);
    }

    private function hitungJarak($lat1, $lng1, $lat2, $lng2): float
    {
        $R = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLng / 2) * sin($dLng / 2);

        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function submitAbsensi(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');

        $sudahAbsen = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('jam_masuk')
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu sudah absen masuk hari ini.',
            ], 200);
        }

        Absensi::create([
            'user_id'         => auth()->id(),
            'jam_masuk'       => $now->toDateTimeString(),
            'koordinat_absen' => $request->koordinat,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil absen masuk!',
        ]);
    }

    public function submitCheckout(Request $request)
    {
        $now = Carbon::now('Asia/Jakarta');
        $jamMenit = $now->format('H:i');

        if ($jamMenit < '15:00' || $jamMenit > '23:00') {
            return response()->json([
                'status' => 'error',
                'message' => 'Checkout Gagal! Sesi absen pulang hanya dibuka jam 15:00 - 23:00 WIB.',
            ], 200);
        }

        $absensi = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (! $absensi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu tidak bisa checkout karena hari ini kamu tidak absen masuk',
            ], 200);
        }

        if ($absensi->jam_pulang != null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamu sudah melakukan checkout sebelumnya hari ini',
            ], 200);
        }

        $absensi->update([
            'jam_pulang' => $now->toDateTimeString(),
            'koordinat_absen' => $request->koordinat,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Checkout. Hati-hati di jalan!',
        ]);
    }

    public function updateStatusAntar(Request $request, $id)
    {
        $driverId = $request->user()->id;
        $pesanan = RiwayatPembelian::with(['user', 'details.produk'])->findOrFail($id);

        if ($pesanan->kurir_id !== $driverId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $ongkirDriver = ($pesanan->tipe_layanan === 'delivery' || $pesanan->tipe_layanan === 'galon')
            ? 3000 : 0;

        $pesanan->update([
            'status_antar' => 'Selesai',
            'status' => 'Lunas',
            'ongkir_driver' => $ongkirDriver,
        ]);

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

    public function grafik(Request $request)
    {
        $user = $request->user();
        $filter = $request->query('filter', 'bulan');

        if ($filter === 'minggu') {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::now('Asia/Jakarta')->subDays($i);
                $total = RiwayatPembelian::where('kurir_id', $user->id)
                    ->whereIn('status_antar', ['selesai', 'Selesai', 'tiba', 'Tiba'])
                    ->where('ongkir_driver', '>', 0)
                    ->whereDate('updated_at', $tanggal->toDateString())
                    ->sum('ongkir_driver');
                $data[] = [
                    'label' => $tanggal->format('d/m'),
                    'total' => (float) $total,
                ];
            }
        } else {
            $data = [];
            for ($i = 5; $i >= 0; $i--) {
                $bulan = Carbon::now('Asia/Jakarta')->subMonths($i);
                $total = RiwayatPembelian::where('kurir_id', $user->id)
                    ->whereIn('status_antar', ['selesai', 'Selesai', 'tiba', 'Tiba'])
                    ->where('ongkir_driver', '>', 0)
                    ->whereYear('updated_at', $bulan->year)
                    ->whereMonth('updated_at', $bulan->month)
                    ->sum('ongkir_driver');
                $data[] = [
                    'label' => $bulan->translatedFormat('M'),
                    'total' => (float) $total,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}