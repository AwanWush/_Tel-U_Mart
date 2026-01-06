<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    public function index(Request $request) // Tambahkan parameter Request di sini
    {
        // 1. Tangkap input filter, default ke bulan & tahun saat ini jika kosong
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));

        $adminGaji = DB::table('admins')
            ->leftJoin('users', 'admins.user_id', '=', 'users.id')
            ->leftJoin('mart', 'admins.mart_id', '=', 'mart.id')
            ->select(
                'admins.id',
                'admins.nama_custom',
                'users.name as nama_user',
                'admins.gaji',
                'admins.jabatan',
                'admins.nama_bank',
                'admins.nomor_rekening',
                'admins.tanggal_gaji',
                'mart.nama_mart'
            )
            // 2. Tambahkan Logika Filter Query
            // Gunakan kolom 'tanggal_gaji' atau 'created_at' sesuai database Anda
            ->whereMonth('admins.tanggal_gaji', $bulan)
            ->whereYear('admins.tanggal_gaji', $tahun)
            ->get();

        // 3. Kirim variabel bulan & tahun kembali ke view agar dropdown tetap terisi (selected)
        return view('superadmin.gaji.index', compact('adminGaji', 'bulan', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'gaji' => 'required|numeric|min:0',
            'mart_id' => 'required|exists:mart,id',
        ]);

        DB::table('admins')->insert([
            'user_id' => null,
            'nama_custom' => $request->nama_pegawai,
            'jabatan' => $request->jabatan,
            'gaji' => $request->gaji,
            'mart_id' => $request->mart_id,
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'tanggal_gaji' => now(), // Menyimpan tanggal saat ini
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gaji' => 'required|numeric|min:0',
            'jabatan' => 'nullable|string',
            'nama_bank' => 'nullable|string',
            'nomor_rekening' => 'nullable|string',
        ]);

        DB::table('admins')->where('id', $id)->update([
            'gaji' => $request->gaji,
            'jabatan' => $request->jabatan,
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            // Opsional: Hapus baris di bawah jika update gaji tidak ingin mengubah bulan rekaman
            // 'tanggal_gaji' => now(), 
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data gaji berhasil diperbarui');
    }
}