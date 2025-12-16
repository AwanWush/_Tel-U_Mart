<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return redirect()->route('login');
});

// ==================== DASHBOARD SESUAI ROLE ==================== //
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Jika belum login → langsung tampilkan dashboard user umum (tanpa auth)
    if (!$user) {
        return view('dashboard.user');
    }

    // Jika login → arahkan sesuai role
    switch ($user->role_id) {
        case 1:
            return view('dashboard.superadmin'); // Super Admin wajib login
        case 2:
            return view('dashboard.admin');      // Admin wajib login
        case 3:
        default:
            return view('dashboard.user');       // User login pun ke dashboard user
    }
})->name('dashboard');


// ==================== Bawaan Breeze ==================== //
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ==================== SUPER ADMIN (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/kelola-admin', 'dashboard.superadmin')->name('admin.manage');
    Route::view('/laporan-bulanan', 'dashboard.superadmin')->name('laporan.bulanan');
    Route::view('/grafik-produk', 'dashboard.superadmin')->name('grafik.produk');
    Route::view('/gaji-admin', 'dashboard.superadmin')->name('gaji.admin');
});

// ==================== ADMIN (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/produk', 'dashboard.admin')->name('produk.index');
    Route::view('/kategori', 'dashboard.admin')->name('kategori.index');
    Route::view('/pesanan', 'dashboard.admin')->name('pesanan.index');
    Route::view('/penjualan-bulan-ini', 'dashboard.admin')->name('penjualan.bulanini');
    Route::view('/produk-laris', 'dashboard.admin')->name('produk.laris');
});

// ==================== USER (TIDAK WAJIB LOGIN) ==================== //
Route::group([], function () {
    Route::view('/produk-list', 'dashboard.user')->name('produk.list');
    Route::view('/pesanan-saya', 'dashboard.user')->name('pesanan.user');
    Route::view('/riwayat-pembelian', 'dashboard.user')->name('riwayat.pembelian');
    Route::view('/profil-saya', 'dashboard.user')->name('profil.user');
});

// ==================== CHECKOUT (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/checkout', 'checkout.index')->name('checkout.index');
});

// ==================== Profil ==================== //
Route::get('/profil/transaksi', [ProfileController::class, 'transaksi'])
    ->middleware(['auth', 'verified'])
    ->name('profil.transaksi');

// Halaman akun khusus user
Route::middleware(['auth'])->group(function () {
    // Halaman profil user
    Route::get('/akun-saya', [ProfileController::class, 'edit'])
        ->name('user.akun');

    // Update profil user
    Route::patch('/akun-saya', [ProfileController::class, 'update'])
        ->name('user.akun.update');
});

// Route untuk versi route-based halaman transaksi
Route::get('/profil/transaksi-page', [ProfileController::class, 'transaksiPage'])
    ->middleware(['auth', 'verified'])
    ->name('profil.transaksi.page');

Route::resource('pembayaran', PembayaranController::class)->except(['show', 'edit', 'update']);
Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
Route::post('/payment/create', [App\Http\Controllers\PaymentController::class, 'createPayment']);
Route::post('/payment/create', [PembayaranController::class, 'createPayment'])
    ->name('payment.create');

Route::post('/payment/callback', [PembayaranController::class, 'callback'])
    ->name('payment.callback');




Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
