<?php

namespace App\Http\Controllers;

use App\Models\LokasiDelivery;
use App\Models\MetodePembayaran;
use App\Models\RiwayatPembelian;
use App\Models\Transaksi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        if ($user->role_id == 3) {

            $transaksi = Transaksi::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.akun', [
                'user' => $user,
                'pesanan' => $transaksi, // kalau ini masih dipakai tab pesanan
                'transaksi' => $transaksi, // WAJIB untuk midtrans
                'riwayat' => RiwayatPembelian::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->get(),
                'gedungs' => LokasiDelivery::orderBy('id', 'asc')->get(),
                'pembayaran' => MetodePembayaran::where('user_id', $user->id)->get(),
                'activeTab' => $request->query('tab', 'pesanan'),
            ]);
        }

        // ============================

        // Admin & superadmin tetap pakai edit.blade lama
        $pesanan = Transaksi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayat = RiwayatPembelian::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        $transaksi = \App\Models\Transaksi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $gedungs = LokasiDelivery::orderBy('id', 'asc')->get();

        $pembayaran = MetodePembayaran::where('user_id', $user->id)->get();

        $activeTab = $request->query('tab', 'pesanan');

        return view('profile.edit', compact('user', 'pesanan', 'activeTab', 'gedungs', 'riwayat', 'pembayaran'));
    }

    public function update(Request $request): RedirectResponse
    {
        // dd("UPDATE MASUK", $request->all());
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'penghuni_asrama' => ['required', 'in:ya,tidak'],
            'alamat_gedung' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        // Upload foto
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada di storage
            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }

            $path = $request->file('gambar')->store('profil', 'public');
            $user->gambar = $path;
        }

        // Password kosong → jangan diupdate
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        // Email berubah → reset verifikasi
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $user->email_verified_at = null; // reset verifikasi jika email berubah
        }
        $user->name = $validated['name'];

        // Update data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->no_telp = $validated['no_telp'];
        $user->penghuni_asrama = $validated['penghuni_asrama'];
        $user->alamat_gedung = $validated['penghuni_asrama'] === 'ya'
            ? $validated['alamat_gedung']
            : null;

        if (isset($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('profile.edit', ['tab' => 'profil'])
            ->with('status', 'Profil berhasil diperbarui!');
    }

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

    public function transaksiPage(Request $request): View
    {
        $user = $request->user();

        $query = Transaksi::where('user_id', $user->id)->orderBy('created_at', 'desc');

        $statusFilter = $request->query('status');
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $transaksi = $query->get();

        return view('profile.transaksi-page', compact('user', 'transaksi', 'statusFilter'));
    }
}
