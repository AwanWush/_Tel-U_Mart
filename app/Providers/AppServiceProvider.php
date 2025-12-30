<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Notification;
use App\Models\Mart;
use App\Models\Produk;
use Midtrans\Config;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\URL;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // if (env('APP_ENV') === 'local') { 
        //     URL::forceScheme('https'); 
        // } 
        /**
         * GLOBAL DATA (cart, wishlist, notif)
         */
if (str_contains(request()->header('Host'), 'ngrok-free')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('cartCount', Cart::where('user_id', Auth::id())->count());
                $view->with('wishlistCount', Wishlist::where('user_id', Auth::id())->count());
                $view->with('notifCount', Notification::where('user_id', Auth::id())->where('is_read', 0)->count());
            } else {
                $view->with('cartCount', 0);
                $view->with('wishlistCount', 0);
                $view->with('notifCount', 0);
            }
        });

        /**
         * MIDTRANS CONFIG
         */
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        /**
         * NAVIGATION + MART SELECTOR
         */
        View::composer('layouts.navigation', function ($view) {
            $user = Auth::user();

            $activeMart = $user?->activeMart
                ?? Mart::where('nama_mart', 'TJMart Putra')->first();

            $marts = Mart::where('is_active', true)
                ->withCount([
                    'produkAll as produk_count'
                ])
                ->get();

            // ✅ TAMBAHAN AMAN (INI SAJA)
            $kategoriList = KategoriProduk::orderBy('nama_kategori')->get();

            // ⬇️ tinggal tambahin ke compact
            $view->with(compact('activeMart', 'marts', 'kategoriList'));
        });

        View::composer('partials.mart-selector', function ($view) {
            $totalProdukSemuaMart = Produk::where('is_active', true)
                ->distinct('produk.id')
                ->count('produk.id');

            $view->with('totalProdukSemuaMart', $totalProdukSemuaMart);
        });
    }
}
