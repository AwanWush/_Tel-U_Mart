<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class NgrokSkipWarning
{
    public function handle(Request $request, Closure $next): Response
    {
        // Paksa HTTPS jika diakses lewat Ngrok
        if (str_contains($request->header('Host'), 'ngrok-free')) {
            URL::forceScheme('https');
        }

        // Tambahkan header bypass ngrok di request
        $request->headers->set('ngrok-skip-browser-warning', 'true');

        $response = $next($request);

        // Tambahkan header bypass ngrok di response
        $response->headers->set('ngrok-skip-browser-warning', 'true');

        // PERBAIKAN: Memastikan Cookie Session aman untuk HTTPS Ngrok
        if (str_contains($request->header('Host'), 'ngrok-free')) {
            foreach ($response->headers->getCookies() as $cookie) {
                // Menambahkan atribut SameSite=None dan Secure secara manual
                $response->headers->set('Set-Cookie', $cookie . '; SameSite=None; Secure', false);
            }
        }

        return $response;
    }
}