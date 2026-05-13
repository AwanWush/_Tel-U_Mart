<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Exports\AbsensiExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Mart;
use App\Models\RiwayatPembelian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SuperAdminController extends Controller
{
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

    public function manageAbsensi(Request $request)
    {
        $filter = $request->get('filter', 'hari_ini');
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');

        $query = Absensi::with('user');

        switch ($filter) {
            case 'seminggu':
                $dari = Carbon::now()->subDays(6)->format('Y-m-d');
                $sampai = Carbon::now()->format('Y-m-d');
                break;

            case 'sebulan':
                $dari = Carbon::now()->startOfMonth()->format('Y-m-d');
                $sampai = Carbon::now()->endOfMonth()->format('Y-m-d');
                break;

            case 'custom':
                break;

            default:
                $filter = 'hari_ini';
                $dari = Carbon::today()->format('Y-m-d');
                $sampai = Carbon::today()->format('Y-m-d');
                break;
        }

        if ($filter !== 'custom' || ($dari && $sampai)) {
            $query->whereBetween('created_at', [
                Carbon::parse($dari)->startOfDay(),
                Carbon::parse($sampai)->endOfDay(),
            ]);
        }

        $absensis = $query->orderBy('created_at', 'desc')->get();

        return view('superadmin.absensi.index', [
            'absensis' => $absensis,
            'activeFilter' => $filter,
            'dari' => $dari,
            'sampai' => $sampai,
        ]);
    }

    public function exportAbsensi(Request $request)
    {
        $filter = $request->get('filter', 'hari_ini');
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');

        $filename = 'absensi_'.$filter.'_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(
            new AbsensiExport($filter, $dari, $sampai),
            $filename
        );
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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
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

    public function editKurir($id)
    {
        $kurir = User::with('admin')->findOrFail($id);

        return response()->json([
            'id' => $kurir->id,
            'name' => $kurir->name,
            'email' => $kurir->email,
            'no_telp' => $kurir->no_telp,
            'nama_bank' => $kurir->admin->nama_bank ?? '',
            'nomor_rekening' => $kurir->admin->nomor_rekening ?? '',
        ]);
    }

    public function updateKurir(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'no_telp' => 'required',
            'nama_bank' => 'required|in:BCA,MANDIRI,BRI,BNI',
            'nomor_rekening' => 'required|numeric|unique:admins,nomor_rekening,'.$id.',user_id',
            'password' => 'nullable|min:8',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            $dataUser = [
                'name' => $request->name,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
            ];

            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                    Storage::disk('public')->delete($user->gambar);
                }
                $dataUser['gambar'] = $request->file('foto')->store('kurir', 'public');
            }

            $user->update($dataUser);

            DB::table('admins')->where('user_id', $id)->update([
                'nama_custom' => $request->name,
                'nama_bank' => $request->nama_bank,
                'nomor_rekening' => $request->nomor_rekening,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data kurir berhasil diperbarui!');
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
        $sekarang = now();
        $jamMenit = $sekarang->format('H:i');
        $userId = auth()->id();

        $absenHariIni = Absensi::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($jamMenit >= '06:30' && $jamMenit <= '08:00') {
            if ($absenHariIni) {
                return response()->json(['status' => 'error', 'message' => 'Anda sudah absen masuk hari ini.'], 422);
            }

            $statusFinal = ($jamMenit <= '07:00') ? 'Tepat Waktu' : 'Terlambat';

            Absensi::create([
                'user_id' => $userId,
                'jam_masuk' => $sekarang,
                'status' => $statusFinal,
                'koordinat_absen' => $request->koordinat,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Berhasil Absen Masuk: '.$statusFinal]);
        }

        if ($jamMenit >= '15:00') {
            if (! $absenHariIni) {
                return response()->json(['status' => 'error', 'message' => 'Anda belum absen masuk pagi tadi!'], 422);
            }

            if ($absenHariIni->jam_pulang != null) {
                return response()->json(['status' => 'error', 'message' => 'Anda sudah absen pulang sebelumnya.'], 422);
            }

            $absenHariIni->update([
                'jam_pulang' => $sekarang,
                'koordinat_absen' => $request->koordinat,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Berhasil Absen Pulang. Hati-hati di jalan!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Bukan jam absensi (06:30-08:00 / 15:00+)'], 422);
    }

    public function sinkronisasiStatusKurir()
    {
        // Ambil semua user dengan role kurir (role_id 2) yang masih aktif
        $drivers = \App\Models\User::where('role_id', 2)->where('status', 'aktif')->get();

        foreach ($drivers as $d) {
            // Ambil data absensi terakhir
            $terakhirAbsen = \Illuminate\Support\Facades\DB::table('absensis')
                ->where('user_id', $d->id)
                ->latest('created_at')
                ->value('created_at');

            // Jika tidak pernah absen atau absen terakhir sudah >= 3 hari yang lalu
            if (! $terakhirAbsen || \Carbon\Carbon::parse($terakhirAbsen)->diffInDays(now()) >= 3) {
                $d->update(['status' => 'nonaktif']);
            }
        }

        return redirect()->back()->with('success', 'Status kurir telah diperbarui otomatis.');
    }

    public function nonaktifkanKurir($id)
    {
        $user = User::findOrFail($id);
        // Ubah status jadi nonaktif
        $user->update(['status' => 'nonaktif']);

        return redirect()->back()->with('success', 'Akun Kurir '.$user->name.' telah dinonaktifkan.');
    }

    public function aktifkanKurir($id)
    {
        $user = User::findOrFail($id);
        // Ubah status jadi aktif kembali
        $user->update(['status' => 'aktif']);

        return redirect()->back()->with('success', 'Akun Kurir '.$user->name.' telah diaktifkan kembali.');
    }

    public function updateStatusDinamis(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'Status '.$user->name.' berhasil diubah menjadi '.$request->status);
    }
}
