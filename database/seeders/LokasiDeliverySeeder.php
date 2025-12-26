<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiDeliverySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lokasi_delivery')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gedungs = [];


        foreach (range('A', 'F') as $huruf) {
            $gedungs[] = [
                'nama_lokasi' => 'Gedung ' . $huruf,
                'nama_gedung' => 'G' . $huruf
            ];
        }

        foreach (range(1, 12) as $angka) {
            $gedungs[] = [
                'nama_lokasi' => 'Gedung ' . $angka,
                'nama_gedung' => 'G' . $angka
            ];
        }


        foreach ($gedungs as $gedung) {
            if (!isset($gedung['nama_lokasi']) || empty($gedung['nama_lokasi'])) {
                throw new \Exception('Nama gedung tidak boleh null!');
            }
        }


        DB::table('lokasi_delivery')->insert($gedungs);

        echo "Seeder LokasiDelivery berhasil dijalankan.\n";
    }
}
