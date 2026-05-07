<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Pastikan baris API ini ada!
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->trustProxies(at: '*'); 

        $middleware->append(\App\Http\Middleware\NgrokSkipWarning::class);
        
        $middleware->validateCsrfTokens(except: [
            'register', 
            'login', 
            'logout', 
            'api/*', // Tambahkan ini agar semua API bebas CSRF
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
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });
    })->create();