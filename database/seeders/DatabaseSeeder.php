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
        // 🔧 Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus dulu isi tabel agar bersih
        DB::table('users')->truncate();
        DB::table('roles')->truncate();

        // Tambahkan data roles
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'Super Admin'],
            ['id' => 2, 'role_name' => 'Admin'],
            ['id' => 3, 'role_name' => 'User'],
        ]);

        // 🔧 Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat user sesuai role
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin123'),
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role_id' => 2,
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'role_id' => 3,
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ]);
    }
}
