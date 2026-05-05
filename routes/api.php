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
        Route::post('/driver/absensi', [DriverController::class, 'submitAbsensi']);
        Route::post('/driver/checkout', [DriverController::class, 'submitCheckout']);

        Route::get('/omset',   [App\Http\Controllers\API\DriverController::class, 'omset']);
        Route::get('/riwayat', [App\Http\Controllers\API\DriverController::class, 'riwayat']);
    });

    Route::get('/produk', [App\Http\Controllers\API\ProductController::class, 'index']);
});