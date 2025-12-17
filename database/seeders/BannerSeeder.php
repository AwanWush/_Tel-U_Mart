<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $banners = [];

        for ($i = 1; $i <= 5; $i++) {
            $number = str_pad($i, 2, '0', STR_PAD_LEFT);

            $banners[] = [
                'title'        => 'banner' . $number,
                'image_path'  => 'banner' . $number . '.jpg',
                'redirect_url'=> null,
                'order'       => $i,
                'is_active'   => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('banners')->insert($banners);
    }
}
