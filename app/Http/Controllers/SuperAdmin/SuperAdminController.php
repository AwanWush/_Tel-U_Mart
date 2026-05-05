<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Mart;
use App\Models\RiwayatPembelian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // app/Http/Controllers/SuperAdmin/SuperAdminController.php

    public function index()
    {
        $totalMart = Mart::where('is_active', 1)->count();
        $totalAdmin = User::where('role_id', 2)->count();
        $totalPendapatan = RiwayatPembelian::where('status', 'Lunas')->sum('total_harga');

        $riwayatTerakhir = RiwayatPembelian::with('user')->latest()->take(5)->get();

        // Grafik Omset
        $grafikOmzet = RiwayatPembelian::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->where('status', 'Lunas')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $labels = $grafikOmzet->pluck('tanggal')->map(fn ($d) => date('d M', strtotime($d)));
        $totals = $grafikOmzet->pluck('total');

        return view('dashboard.superadmin', compact(
            'totalMart', 'totalAdmin', 'totalPendapatan', 'riwayatTerakhir', 'labels', 'totals'
        ));
    }

    public function manageAbsensi()
    {
        // Halaman ini khusus untuk mengelola absensi driver
        $absensis = Absensi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('jam_masuk', 'desc')
            ->get();

        return view('superadmin.absensi.index', compact('absensis'));
    }

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

    public function manageKurir()
    {
        $kurirs = User::whereHas('role', function ($q) {
            $q->where('role_name', 'admin');
        })->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('admins')
                ->whereRaw('admins.user_id = users.id')
                ->where('jabatan', 'Kurir');
        })->with('admin')->get();

        return view('superadmin.kurir.index', compact('kurirs'));
    }

    public function storeKurir(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            'no_telp' => 'required',
            'nama_bank' => 'required|in:BCA,MANDIRI,BRI,BNI',
            'nomor_rekening' => 'required|numeric|unique:admins,nomor_rekening',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ✅ tambahan
        ]);

        DB::beginTransaction();
        try {

            // ✅ HANDLE FOTO
            $pathFoto = null;
            if ($request->hasFile('foto')) {
                $pathFoto = $request->file('foto')->store('kurir', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
                'no_telp' => $request->no_telp,
                'gambar' => $pathFoto,
                'status' => 'aktif',
            ]);

            DB::table('admins')->insert([
                'user_id' => $user->id,
                'nama_custom' => $request->name,
                'jabatan' => 'Kurir',
                'nama_bank' => $request->nama_bank,
                'nomor_rekening' => $request->nomor_rekening,
                'gaji' => 0,
                'tanggal_gaji' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Kurir berhasil didaftarkan!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Gagal: '.$e->getMessage());
        }
    }

    public function destroyKurir($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun Kurir berhasil dihapus.');
    }

    public function prosesAbsen(Request $request)
    {
        // 1. Ambil waktu sekarang (Sudah Asia/Jakarta)
        $sekarang = now();
        $jamMenit = $sekarang->format('H:i');

        // 2. Validasi Batas Akhir (Jam 08:00)
        if ($jamMenit > '08:00') {
            return response()->json([
                'status' => 'error',
                'message' => 'Absensi ditolak! Batas waktu maksimal adalah 08:00 WIB.',
            ], 422);
        }

        // 3. Cek Batas Awal (Jam 06:30)
        if ($jamMenit < '06:30') {
            return response()->json([
                'status' => 'error',
                'message' => 'Absensi belum dibuka. Mulai jam 06:30 WIB.',
            ], 422);
        }

        // 4. Tentukan Status Berdasarkan Aturan
        // 06:30 - 07:00 => Tepat Waktu
        // 07:01 - 08:00 => Terlambat
        if ($jamMenit >= '06:30' && $jamMenit <= '07:00') {
            $statusFinal = 'Tepat Waktu';
        } else {
            $statusFinal = 'Terlambat';
        }

        // 5. Simpan ke Database tubes_pbw2
        Absensi::create([
            'user_id' => auth()->id(), // ID Driver yang login
            'jam_masuk' => $sekarang,
            'status' => $statusFinal,
            'koordinat_absen' => $request->koordinat,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil: '.$statusFinal,
        ]);
    }
}
