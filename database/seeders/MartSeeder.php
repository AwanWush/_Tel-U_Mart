<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('mart')->truncate(); // menghidari duplikat data

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $mart = [
            [
                'id' => 1,
                'nama_mart' => 'TJ Mart Putra',
                'alamat' => 'Belakang Gedung 1 Asrama Putra, dekat Sport Center, Universitas Telkom Bandung',
                'deskripsi' => null,
                'is_active' => true,
                'created_at' => '2025-10-24 18:55:01',
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nama_mart' => 'T Mart Putra',
                'alamat' => 'Depan Gedung 8 Asrama Putra, dekat Mushola Kantin Asrama, Universitas Telkom Bandung',
                'deskripsi' => null,
                'is_active' => true,
                'created_at' => '2025-10-24 18:55:01',
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'nama_mart' => 'TJ Mart Putri',
                'alamat' => 'Belakang Gedung A Asrama Putri Universitas Telkom Bandung',
                'deskripsi' => null,
                'is_active' => true,
                'created_at' => '2025-10-24 18:55:01',
                'updated_at' => now()
            ]
        ];

        DB::table('mart')->insert($mart);
    }
}
