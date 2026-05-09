<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $drivers = User::where('role_id', 2)->where('status', 'aktif')->get();

    foreach ($drivers as $d) {
        // Ambil data absensi terakhir
        $terakhirAbsen = DB::table('absensis')
            ->where('user_id', $d->id)
            ->latest('created_at')
            ->value('created_at');

        // Jika tidak pernah absen atau sudah 3 hari tidak absen
        if (!$terakhirAbsen || Carbon::parse($terakhirAbsen)->diffInDays(now()) >= 3) {
            $d->update(['status' => 'nonaktif']);
        }
    }
})->dailyAt('23:59'); 