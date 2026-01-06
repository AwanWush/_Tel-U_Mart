<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        // --- TAMBAHKAN INI ---
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class, // Pastikan path class ini benar sesuai file middleware Anda
        ]);
        // ---------------------

        // 1. Agar Laravel percaya IP dari Ngrok
        $middleware->trustProxies(at: '*'); 

        // 2. Tambahkan Middleware Ngrok kamu
        $middleware->append(\App\Http\Middleware\NgrokSkipWarning::class);
        
        // 3. Bypass CSRF
        $middleware->validateCsrfTokens(except: [
            'register', 
            'login', 
            'logout', 
            'beranda*', 
            'galon*', 
            'token*', 
            'keranjang*', 
            'wishlist*', 
            'notifikasi*', 
            'produk*'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();