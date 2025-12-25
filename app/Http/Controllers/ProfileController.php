<?php

namespace App\Http\Controllers;

use App\Models\LokasiDelivery;
use App\Models\MetodePembayaran;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\RiwayatPembelian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil (Edit)
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $userId = $user->id;

        // Ambil data transaksi (untuk tab pesanan aktif)
        $transaksi = Transaksi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // 1. Cek tabel riwayat_pembelian untuk Riwayat Pesanan Saya
        $riwayat = [];
        if (Schema::hasTable('riwayat_pembelian')) {
            $riwayat = RiwayatPembelian::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
        }

        // 2. Cek tabel metode_pembayaran
        $pembayaran = [];
        if (Schema::hasTable('metode_pembayaran')) {
            $pembayaran = MetodePembayaran::where('user_id', $userId)->get();
        }

        $gedungs = LokasiDelivery::orderBy('id', 'asc')->get();
        $activeTab = $request->query('tab', 'pesanan');

        // Logic penentuan View: Customer (Role 3) ke user.akun, Admin/Super ke profile.edit
        $viewPath = ($user->role_id == 3) ? 'user.akun' : 'profile.edit';

        return view($viewPath, [
            'user' => $user,
            'pesanan' => $transaksi,
            'transaksi' => $transaksi,
            'riwayat' => $riwayat,
            'gedungs' => $gedungs,
            'pembayaran' => $pembayaran,
            'activeTab' => $activeTab,
        ]);
    }

    /**
     * Update data profil
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'penghuni_asrama' => ['required', 'in:ya,tidak'],
            'lokasi_id' => ['nullable', 'exists:lokasi_delivery,id'],
            'nomor_kamar' => ['nullable', 'string', 'max:10'],
            'alamat_gedung' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        // Upload foto profil
        if ($request->hasFile('gambar')) {
            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }
            $path = $request->file('gambar')->store('profil', 'public');
            $user->gambar = $path;
        }

        // Update data dasar
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->no_telp = $validated['no_telp'];
        $user->penghuni_asrama = $validated['penghuni_asrama'];

        // Logika Lokasi Asrama
        if ($validated['penghuni_asrama'] === 'ya') {
            $user->lokasi_id = $validated['lokasi_id'];
            $user->nomor_kamar = $validated['nomor_kamar'];
            
            $gedung = LokasiDelivery::find($validated['lokasi_id']);
            $user->alamat_gedung = $gedung ? $gedung->nama_lokasi : $validated['alamat_gedung'];
        } else {
            $user->lokasi_id = null;
            $user->nomor_kamar = null;
            $user->alamat_gedung = $validated['alamat_gedung'] ?? null;
        }

        // Update Password jika diisi
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit', ['tab' => 'profil'])
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Halaman khusus transaksi (Opsional)
     */
    public function transaksiPage(Request $request): View
    {
        $user = $request->user();
        $query = Transaksi::where('user_id', $user->id)->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $transaksi = $query->get();

        return view('profile.transaksi-page', [
            'user' => $user,
            'transaksi' => $transaksi,
            'statusFilter' => $request->query('status')
        ]);
    }
    public function simpanKeRiwayat($transaksiId) 
{
    $transaksi = Transaksi::find($transaksiId);

    if ($transaksi) {
        RiwayatPembelian::create([
            'user_id'           => $transaksi->user_id,
            'id_transaksi'      => $transaksi->id_transaksi, // Sesuaikan dengan field di tabel transaksi Anda
            'total_harga'       => $transaksi->total_harga,
            'status'            => 'Sukses',
            'metode_pembayaran' => $transaksi->metode_pembayaran,
        ]);
    }
}

public function index()
{
    $userId = auth()->id();

    // Mengambil riwayat berdasarkan user yang sedang login
    $riwayat = \App\Models\RiwayatPembelian::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

    // Kembalikan ke view user/akun (karena Anda tidak pakai profile/index)
    return view('user.akun', compact('riwayat'));
}
}