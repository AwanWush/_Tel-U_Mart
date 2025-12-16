<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            // dd($user->role_id);

            // arahkan sesuai role_id
            if ($user->role_id == 1) {
                return redirect()->route('dashboard.superadmin');
            } elseif ($user->role_id == 2) {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role_id == 3) {
                return redirect()->route('dashboard.user');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'email', 'unique:users,email'],
           'password' => ['required', 'confirmed', 'min:6'],
        ]);

        User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role_id' => 3,
           'remember_token' => Str::random(60),
            'email_verified_at' => now(),

        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
