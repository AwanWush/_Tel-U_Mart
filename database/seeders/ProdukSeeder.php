<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('produk')->truncate();      // Hapus data lama
        DB::table('produk_mart')->truncate(); // hapus data tabel pivot many-to-many
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $produk1 = Produk::create([
            'kategori_id' => 4, 
            'nama_produk' => 'Potabee',
            'deskripsi' => null,
            'harga' => 8000,
            'stok' => 31,
            'gambar' => 'produk/product06.jpg',
            'status_ketersediaan' => 'Tersedia',
            'is_active' => true,
            'persentase_diskon' => null
        ]);
        $produk1->marts()->attach([1, 2]); // Relasi ke mart

        $produk2 = Produk::create([
            'kategori_id' => 4, 
            'nama_produk' => 'Chitato',
            'deskripsi' => null,
            'harga' => 9000,
            'stok' => 20,
            'gambar' => 'produk/product05.png',
            'status_ketersediaan' => 'Tersedia',
            'is_active' => true,
            'persentase_diskon' => null
        ]);
        $produk2->marts()->attach([1, 3]);

        $produk3 = Produk::create([
            'kategori_id' => 4, 
            'nama_produk' => 'Pringles',
            'deskripsi' => null,
            'harga' => 17000,
            'stok' => 13,
            'gambar' => 'produk/product04.jpg',
            'status_ketersediaan' => 'Tersedia',
            'is_active' => true,
            'persentase_diskon' => null
        ]);
        $produk3->marts()->attach([3]);

        $produk4 = Produk::create([
            'kategori_id' => 2, 
            'nama_produk' => 'Cimory Squeee',
            'deskripsi' => null,
            'harga' => 7100,
            'stok' => 47,
            'gambar' => 'produk/product07.jpg',
            'status_ketersediaan' => 'Tersedia',
            'is_active' => true,
            'persentase_diskon' => null
        ]);
        $produk4->marts()->attach([2]);
    }
}
