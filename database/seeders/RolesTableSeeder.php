<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('roles')->truncate();

        $roles = [
            [
                'id' => 1, 
                'role_name' => 'super_admin', 
                'created_at' => '2025-10-24 18:55:01', 
                'updated_at' => now()
            ],
            [
                'id' => 2, 
                'role_name' => 'admin', 
                'created_at' => '2025-10-24 18:55:01', 
                'updated_at' => now()
            ],
            [
                'id' => 3, 
                'role_name' => 'user', 
                'created_at' => '2025-10-24 18:55:01', 
                'updated_at' => now()
            ],
        ];

        DB::table('roles')->insert($roles);

        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
