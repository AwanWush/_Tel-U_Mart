<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // PENTING: Tambahkan ini

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = DB::table('users')
            ->leftJoin('mart', 'users.mart_id', '=', 'mart.id')
            ->where('users.role_id', 2)
            ->select('users.id', 'users.name', 'users.email', 'users.status', 'mart.nama_mart', 'users.mart_id')
            ->get();

        // Ambil mart yang aktif untuk dropdown
        $marts = DB::table('mart')->get();

        return view('superadmin.admin.index', compact('admins', 'marts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'mart_id' => 'required|exists:mart,id',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, 
            'mart_id' => $request->mart_id,
            'status' => 'aktif', // Memberikan status awal aktif
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function updateMart(Request $request, $id)
    {
        $request->validate([
            'mart_id' => 'required|exists:mart,id',
        ]);

        DB::table('users')->where('id', $id)->update([
            'mart_id' => $request->mart_id,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Lokasi tugas admin berhasil diperbarui.');
    }

    // Fitur Tambahan: Toggle Aktif/Nonaktif Admin
    public function toggleStatus($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $newStatus = ($user->status == 'aktif') ? 'nonaktif' : 'aktif';

        DB::table('users')->where('id', $id)->update(['status' => $newStatus]);

        return back()->with('success', 'Status admin berhasil diubah.');
    }
}