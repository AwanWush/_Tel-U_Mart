<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LokasiDelivery;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        // 🔹 Tambahan: ambil data gedung dari tabel lokasi_delivery
        $lokasi = LokasiDelivery::orderByRaw('CAST(id AS UNSIGNED) ASC')->get();
        return view('auth.register', compact('lokasi'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'lokasi_id' => ['nullable', 'exists:lokasi_delivery,id'],
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('profil', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,     
            'gambar' => $gambarPath,            
            'lokasi_id' => $request->lokasi_id, 
            'password' => Hash::make($request->password),
            'role_id' => 3,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di TJ-T Mart 👋');
    }
}
