<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiDeliverySeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Nonaktifkan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 🔹 Kosongkan tabel dulu agar tidak duplikat
        DB::table('lokasi_delivery')->truncate();

        // 🔹 Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gedungs = [];

        // Gedung A - F
        foreach (range('A', 'F') as $huruf) {
            $gedungs[] = [
                'nama_lokasi' => 'Gedung ' . $huruf,
                'nama_gedung' => 'G' . $huruf
            ];
        }

        // Gedung 1 - 12
        foreach (range(1, 12) as $angka) {
            $gedungs[] = [
                'nama_lokasi' => 'Gedung ' . $angka,
                'nama_gedung' => 'G' . $angka
            ];
        }

        // 🔹 Pastikan semua data valid sebelum insert
        foreach ($gedungs as $gedung) {
            if (!isset($gedung['nama_lokasi']) || empty($gedung['nama_lokasi'])) {
                throw new \Exception('Nama gedung tidak boleh null!');
            }
        }

        // 🔹 Masukkan data ke tabel
        DB::table('lokasi_delivery')->insert($gedungs);

        echo "Seeder LokasiDelivery berhasil dijalankan.\n";
    }
}
