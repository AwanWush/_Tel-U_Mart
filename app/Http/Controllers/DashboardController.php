<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirectBasedOnRole()
    {
        $role = Auth::user()->role->role_name ?? null;

        return match ($role) {
            'super_admin' => redirect()->route('dashboard.superadmin'),
            'admin' => redirect()->route('dashboard.admin'),
            default => redirect()->route('dashboard.user'),
        };
    }

    public function superadmin() { return view('dashboards.superadmin'); }
    public function admin() { return view('dashboards.admin'); }
    public function user() { return view('dashboards.user'); }
}
