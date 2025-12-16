<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('kategori_produk')->truncate();   // Hapus data lama agar tidak duplikat data

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kategori = [
            ['id' => 1, 'nama_kategori' => 'Makanan'],
            ['id' => 2, 'nama_kategori' => 'Minuman'],
            ['id' => 3, 'nama_kategori' => 'Alat Tulis'],
            ['id' => 4, 'nama_kategori' => 'Snack'],
            ['id' => 5, 'nama_kategori' => 'Perlengkapan Kebersihan'],
            ['id' => 6, 'nama_kategori' => 'Elektronik'],
            ['id' => 7, 'nama_kategori' => 'Token Listrik'],
            ['id' => 8, 'nama_kategori' => 'Galon'],
            ['id' => 9, 'nama_kategori' => 'Lainnya'],
        ];

        DB::table('kategori_produk')->insert($kategori);
    }
}
