<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            UserSeeder::class,
            KategoriProdukSeeder::class,
            MartSeeder::class,
            ProdukSeeder::class,
            BannerSeeder::class,
            ProdukssSeeder::class,
        ]);
    }
}
