<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/driver/login', [AuthController::class, 'loginDriver']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('driver')->group(function () {
        Route::get('/pesanan',                     [App\Http\Controllers\API\DriverController::class, 'index']);
        Route::post('/pesanan/{id}/update-status', [App\Http\Controllers\API\DriverController::class, 'updateStatus']);
        Route::post('/pesanan/{id}/claim',         [App\Http\Controllers\API\DriverController::class, 'claim']);
        Route::post('/pesanan/{id}/batalkan',      [App\Http\Controllers\API\DriverController::class, 'batalkan']);

        Route::get('/profile',       [App\Http\Controllers\API\DriverController::class, 'profile']);
        Route::post('/upload-photo', [App\Http\Controllers\API\DriverController::class, 'uploadPhoto']);

        Route::post('/absensi',  [App\Http\Controllers\API\DriverController::class, 'submitAbsensi']);
        Route::post('/checkout', [App\Http\Controllers\API\DriverController::class, 'submitCheckout']);

        Route::post('/pesanan/{id}/status-antar', [App\Http\Controllers\API\DriverController::class, 'updateStatusAntar']);

        Route::get('/omset',   [App\Http\Controllers\API\DriverController::class, 'omset']);
        Route::get('/riwayat', [App\Http\Controllers\API\DriverController::class, 'riwayat']);
        Route::get('/grafik',  [App\Http\Controllers\API\DriverController::class, 'grafik']);

        // Reward
        Route::get('/reward/status', [App\Http\Controllers\API\DriverController::class, 'rewardStatus']);
        Route::post('/reward/klaim', [App\Http\Controllers\API\DriverController::class, 'rewardKlaim']);
    });

    Route::get('/produk', [App\Http\Controllers\API\ProductController::class, 'index']);
});