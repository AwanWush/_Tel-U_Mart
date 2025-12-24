<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\UserGalonController;
use App\Http\Controllers\UserTokenController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\MartController;

Route::get('/', function () {
    return redirect()->route('login');
});

//==================== DASHBOARD SESUAI ROLE ==================== //
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

// satu pintu dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// admin dashboard
Route::middleware(['auth', 'verified'])->get(
    '/dashboard/admin',
    [DashboardController::class, 'admin']
)->name('dashboard.admin');

// super admin dashboard
Route::middleware(['auth', 'verified'])->get(
    '/dashboard/superadmin',
    [DashboardController::class, 'superadmin']
)->name('dashboard.superadmin');

// user dashboard
Route::get('/dashboard/user', [DashboardController::class, 'user'])
    ->name('dashboard.user');


// ==================== Bawaan Breeze ==================== //
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// ==================== USER (TIDAK WAJIB LOGIN) ==================== //
Route::group([], function () {
    
    Route::view('/produk-list', 'dashboard.user')->name('produk.list');
    Route::view('/pesanan-saya', 'dashboard.user')->name('pesanan.user');
    Route::view('/riwayat-pembelian', 'dashboard.user')->name('riwayat.pembelian');
    Route::view('/profil-saya', 'dashboard.user')->name('profil.user');
});

// ==================== USER PRODUK ====================
Route::get('/produk', [ProdukController::class, 'index'])
    ->name('produk.index');

Route::get('/produk/{produk}', [ProdukController::class, 'show'])
    ->name('produk.show');

// ==================== CHECKOUT (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/checkout', 'checkout.index')->name('checkout.index');
});

// ==================== Profil ==================== //
Route::get('/profil/transaksi', [ProfileController::class, 'transaksi'])
->middleware(['auth', 'verified'])
->name('profil.transaksi');

// ==================== FITUR TAMBAHAN: GALON & TOKEN LISTRIK ==================== //
Route::middleware(['auth'])->group(function () {
    
    // Token
    Route::get('/token-listrik', [UserTokenController::class, 'index'])->name('token.index');
    Route::post('/token-listrik/beli', [UserTokenController::class, 'store'])->name('token.store');
    
    // Riwayat Token
    Route::get('/token-listrik/riwayat', [UserTokenController::class, 'history'])->name('token.history');
    Route::get('/token-listrik/detail/{id}', [UserTokenController::class, 'detail'])->name('token.detail');
    
    // Galon
    Route::get('/galon', [UserGalonController::class, 'index'])->name('galon.index');
    Route::post('/galon/beli', [UserGalonController::class, 'store'])->name('galon.store');
    
    // Riwayat Galon
    Route::get('/galon/riwayat', [UserGalonController::class, 'history'])->name('galon.history');
    
    // Detail Galon
    Route::get('/galon/detail/{id}', [UserGalonController::class, 'detail'])->name('galon.detail');
});

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


Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class,'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class,'remove'])->name('cart.remove');
});



// Route::middleware(['auth'])->post(
//     '/checkout/selected',
//     [CheckoutController::class, 'selected']
//     )->name('checkout.selected');
    
    Route::middleware(['auth'])->group(function () {
        
        Route::get('/wishlist', [WishlistController::class,'index'])
        ->name('wishlist.index');
        
    Route::post('/wishlist', [WishlistController::class,'store'])
    ->name('wishlist.store');

    Route::post('/wishlist/remove-selected', [WishlistController::class,'removeSelected'])
    ->name('wishlist.removeSelected');

    Route::post('/wishlist/move-to-cart', [WishlistController::class,'moveToCart'])
    ->name('wishlist.moveToCart');
    
    Route::delete('/wishlist/{id}', [WishlistController::class,'destroy'])
    ->name('wishlist.destroy');
});



Route::middleware(['auth'])->group(function () {
    
    Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');
    
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
    ->name('notifications.read');
    
    Route::post('/notifications/read-selected', [NotificationController::class, 'readSelected'])
    ->name('notifications.readSelected');
    
    Route::post('/notifications/delete-selected', [NotificationController::class, 'deleteSelected'])
    ->name('notifications.deleteSelected');
});


Route::resource('pembayaran', PembayaranController::class)->except(['show', 'edit', 'update']);
Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
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



// // ==================== ADMINN ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('admin/produk', AdminProdukController::class)
        ->names('admin.produk')
        ->except(['show']);
    Route::resource('admin/kategori', KategoriProdukController::class)
        ->names('admin.kategori')
        ->except(['show']);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/pesanan', [PesananController::class, 'index'])
        ->name('admin.pesanan.index');
});
    Route::get('/admin/penjualan-bulan-ini', [DashboardController::class, 'admin'])->name('penjualan.bulanini');
    Route::get('/admin/produk-laris', [DashboardController::class, 'admin'])->name('produk.laris');

    Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'selected'])->name('checkout.selected');
});

// ==================== SUPER ADMIN (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/kelola-admin', 'dashboard.superadmin')->name('admin.manage');
    Route::view('/laporan-bulanan', 'dashboard.superadmin')->name('laporan.bulanan');
    Route::view('/grafik-produk', 'dashboard.superadmin')->name('grafik.produk');
    Route::view('/gaji-admin', 'dashboard.superadmin')->name('gaji.admin');
});

// ===== Mart to user ===== //
Route::post('/select-mart', [MartController::class, 'select'])
    ->middleware('auth')
    ->name('mart.select');