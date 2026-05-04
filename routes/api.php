<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// API untuk Android Studio
Route::post('/driver/login', [AuthController::class, 'loginDriver']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('driver')->group(function () {
        // Pesanan
        Route::get('/pesanan',                    [App\Http\Controllers\API\DriverController::class, 'index']);
        Route::post('/pesanan/{id}/update-status',[App\Http\Controllers\API\DriverController::class, 'updateStatus']);
        Route::post('/pesanan/{id}/claim',        [App\Http\Controllers\API\DriverController::class, 'claim']);

        // Profil
        Route::get('/profile',      [App\Http\Controllers\API\DriverController::class, 'profile']);
        Route::post('/upload-photo',[App\Http\Controllers\API\DriverController::class, 'uploadPhoto']);

        // Omset & Riwayat
        Route::get('/omset',   [App\Http\Controllers\API\DriverController::class, 'omset']);
        Route::get('/riwayat', [App\Http\Controllers\API\DriverController::class, 'riwayat']);
    });

    // Produk umum
    Route::get('/produk', [App\Http\Controllers\API\ProductController::class, 'index']);
});