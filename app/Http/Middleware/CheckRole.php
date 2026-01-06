<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Logika Pengecekan Role
        // 1 = Super Admin, 2 = Admin Mart
        if ($role === 'superadmin' && $user->role_id != 1) {
            abort(403, 'Otoritas Tidak Diizinkan.');
        }

        if ($role === 'admin' && $user->role_id != 2) {
            abort(403, 'Otoritas Tidak Diizinkan.');
        }

        return $next($request);
    }
}