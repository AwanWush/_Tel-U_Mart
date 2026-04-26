<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Cek apakah sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil user yang login
        $user = Auth::user();

        /** * 3. Bandingkan role_name dari relasi role di model User 
         * Kita gunakan str_replace untuk jaga-jaga jika ada perbedaan penulisan
         * antara 'super_admin' (di DB) dan 'superadmin' (di Route)
         */
        $userRoleName = str_replace('_', '', $user->role->role_name); // super_admin -> superadmin
        $requiredRole = str_replace('_', '', $role);

        if ($userRoleName !== $requiredRole) {
            abort(403, 'Akses ditolak. Anda login sebagai ' . $user->role->role_name);
        }

        return $next($request);
    }
}