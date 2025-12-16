<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        DB::table('roles')->delete();

        // Tambah data baru
        DB::table('roles')->insert([
        ['id' => 1, 'role_name' => 'super_admin', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 2, 'role_name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ['id' => 3, 'role_name' => 'user', 'created_at' => now(), 'updated_at' => now()],
    ]);

    }
}
