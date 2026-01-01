<?php
use App\Http\Controllers\PaymentController;
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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\MetodePembayaranController;


Route::post('/pembayaran', [MetodePembayaranController::class, 'store'])
    ->name('pembayaran.store')
    ->middleware('auth');

    // Route::post('/checkout', [CheckoutController::class, 'processCheckout'])
    // ->name('checkout.process');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout');

    
Route::middleware(['auth'])->group(function () {

    // HALAMAN CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    // PROSES CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])
        ->name('checkout.process');


    // BELI SEKARANG (POST)
    Route::post('/checkout/direct', [CheckoutController::class, 'directCheckout'])
        ->name('checkout.direct');

    // CHECKOUT DARI CART (POST)
    Route::post('/cart/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');

    // PROSES CHECKOUT → PAYMENT
    Route::post('/checkout/process', [CheckoutController::class, 'processSuccess'])
        ->name('checkout.process');
    //     Route::get('/checkout/page', [CheckoutController::class, 'checkoutPage'])
    // ->name('checkout.page');

    // Payment Method
    Route::get('/payment/method', [CheckoutController::class, 'showPaymentMethod'])
        ->middleware(['auth'])
        ->name('payment.method');
});
Route::post('/checkout/selected', [CheckoutController::class, 'selected'])
    ->name('checkout.selected');

Route::patch('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.remove');
Route::post('/checkout/selected', [CheckoutController::class, 'index'])->name('checkout.selected');
// Route::get('/order/success/{order_id}', [App\Http\Controllers\CheckoutController::class, 'showSuccess'])->name('order.success');
// Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');
// Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
// Route::post('/checkout/process', [CheckoutController::class, 'processSuccess'])->name('checkout.process');
Route::get('/order/success/{order_id}', [CheckoutController::class, 'showSuccess'])->name('order.success');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
// Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
// Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
// Route::get('/order/success', [CheckoutController::class, 'showSuccess'])
//     ->name('order.success');

// Route::post('/payment/snap-token', [PaymentController::class, 'getSnapToken'])
//     ->name('payment.snap-token');
// Route::post('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
// Route::get('/order/success', [CheckoutController::class, 'showSuccess'])->name('order.success');

Route::get('/order/success', [OrderController::class, 'success'])
    ->name('order.success');
Route::get('/', function () {
    return redirect()->route('login'); 
    
});

//==================== DASHBOARD SESUAI ROLE ==================== //
// Route::get('/dashboard', function () {
//     $user = Auth::user();

//     // Jika belum login → langsung tampilkan dashboard user umum (tanpa auth)
//     if (!$user) {
//         return view('dashboard.user');
//     }

//     // Jika login → arahkan sesuai role
//     switch ($user->role_id) {
//         case 1:
//             return view('dashboard.superadmin'); // Super Admin wajib login
//         case 2:
//             return view('dashboard.admin');      // Admin wajib login
//         case 3:
//         default:
//             return view('dashboard.user');       // User login pun ke dashboard user
//     }
// })->name('dashboard');

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
// ==================== USER KATEGORI PRODUK ====================
Route::get('/kategori/{kategori}', [ProdukController::class, 'byKategori'])
    ->name('produk.by-kategori');
// // routes/web.php
// Route::get('/produk', [App\Http\Controllers\ProdukController::class, 'index'])->name('produk.index');
// Route::get('/produk/{produk}', [App\Http\Controllers\ProdukController::class, 'show'])->name('produk.show');

require __DIR__.'/auth.php';
// ==================== CHECKOUT (WAJIB LOGIN) ==================== //
// Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/checkout', 'checkout.index')->name('checkout.index');
// });

// ==================== Profil ==================== //
Route::get('/profil/transaksi', [ProfileController::class, 'transaksi'])
->middleware(['auth', 'verified'])
->name('profil.transaksi');

// ==================== FITUR TAMBAHAN: GALON & TOKEN LISTRIK ==================== //
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/method', [CheckoutController::class, 'showPaymentMethod'])
        ->name('payment.method');
    Route::post('/payment/snap-token', [PaymentController::class, 'getSnapToken'])
        ->name('payment.snap-token');
    Route::post('/payment/snap-galon', [PaymentController::class, 'snapGalon'])
        ->name('payment.snap-galon');
    Route::post('/payment/snap-product', [PaymentController::class, 'snapProduct'])
        ->name('payment.snap-product');
        
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/payment/method', [CheckoutController::class, 'showPaymentMethod'])->name('payment.method');
    // Token
    Route::get('/token-listrik', [UserTokenController::class, 'index'])->name('token.index');
    Route::post('/token-listrik/beli', [UserTokenController::class, 'store'])->name('token.store');
    
    // Riwayat Token
    Route::get('/token-listrik/riwayat', [UserTokenController::class, 'history'])->name('token.history');
    Route::get('/token-listrik/detail/{id}', [UserTokenController::class, 'detail'])->name('token.detail');

    Route::get('/token/result/{id}', [UserTokenController::class, 'result'])
        ->name('token.result');
    
    // Galon
    Route::get('/galon', [UserGalonController::class, 'index'])->name('galon.index');
    Route::post('/galon/beli', [UserGalonController::class, 'store'])->name('galon.store');
    
    // Riwayat Galon
    Route::get('/galon/riwayat', [UserGalonController::class, 'history'])->name('galon.history');
    
    Route::get('/fitur-user/galon-result/{id}', [UserGalonController::class, 'result'])
        ->name('galon.result');

    Route::post('/galon/store-midtrans', [UserGalonController::class, 'storeMidtrans'])
        ->name('galon.store.midtrans');

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

// Hapus atau keluarkan dari Route::prefix('bantuan')
Route::get('/kontak', function () {
    return view('fitur-user.kontak');
})->name('kontak.index');

Route::get('/tentang-kami', function () {
    return view('fitur-user.tentang');
})->name('tentang.index');

Route::get('/faq', function () {
    return view('fitur-user.faq');
})->name('faq.index');

Route::get('/search', [ProdukController::class, 'search'])->name('produk.search');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-selected', [NotificationController::class, 'readSelected'])
        ->name('notifications.readSelected');

    Route::post('/notifications/delete-selected', [NotificationController::class, 'deleteSelected'])
        ->name('notifications.deleteSelected');

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
});

Route::get('/riwayat-pembelian', [RiwayatController::class, 'index'])->name('riwayat.pembelian');

// Route::resource('pembayaran', PembayaranController::class)->except(['show', 'edit', 'update']);
// Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
// Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
Route::resource('pembayaran', PembayaranController::class)->only(['index', 'create', 'store', 'destroy']);
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
    Route::post('/admin/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.update');
});
    Route::get('/admin/penjualan-bulan-ini', [DashboardController::class, 'admin'])->name('penjualan.bulanini');
    Route::get('/admin/produk-laris', [DashboardController::class, 'admin'])->name('produk.laris');

    Route::middleware(['auth', 'verified'])->group(function () {

        
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