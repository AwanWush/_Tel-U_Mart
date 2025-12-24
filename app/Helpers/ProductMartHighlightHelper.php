<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Mart;

if (! function_exists('activeMart')) {
    function activeMart()
    {
        return Auth::user()?->activeMart
            ?? Mart::where('nama_mart', 'TJMart Putra')->first();
    }
}
