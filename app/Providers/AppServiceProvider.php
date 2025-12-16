<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Notification;
use Midtrans\Config;


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
        view()->composer('*', function ($view) {
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
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
