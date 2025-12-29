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
        // 1. Agar Laravel percaya IP dari Ngrok (PENTING untuk Session)
        $middleware->trustProxies(at: '*'); 

        // 2. Tambahkan Middleware Ngrok kamu
        $middleware->append(\App\Http\Middleware\NgrokSkipWarning::class);
        
        // 3. Bypass CSRF agar tidak 419 Page Expired
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