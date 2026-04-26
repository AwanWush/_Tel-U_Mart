<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// API untuk Android Studio
Route::post('/driver/login', [AuthController::class, 'loginDriver']);
Route::middleware('auth:sanctum')->group(function () {
    // ... route yang sudah ada (me, logout)

    // Fitur untuk Aplikasi Driver (Android)
    Route::prefix('driver')->group(function () {
        // Ambil daftar pesanan yang harus diantar oleh kurir
        Route::get('/pesanan', [App\Http\Controllers\API\DriverController::class, 'index']);
        // Update status pesanan (misal: dari 'diproses' ke 'selesai')
        Route::post('/pesanan/{id}/update-status', [App\Http\Controllers\API\DriverController::class, 'updateStatus']);
    });

    // Fitur umum (jika Android user biasa ingin liat produk)
    Route::get('/produk', [App\Http\Controllers\API\ProductController::class, 'index']);
});