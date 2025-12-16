<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\User;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all(); // Ambil semua user yang ada

        $produkList = ['Beras 5kg', 'Minyak 1L', 'Gula 1kg', 'Telur 1kg', 'Kopi Bubuk', 'Teh Celup', 'Susu 1L'];
        $statusList = ['Terbuat', 'Menunggu Pembayaran', 'Sedang Diproses', 'Dikirim', 'Sudah Tiba'];
        $metodeList = ['Cash', 'QRIS', 'TF Bank'];
        $totalList = [15000, 25000, 28000, 75000, 18000, 22000, 30000];

        foreach ($users as $user) {
            // Jumlah transaksi per user acak antara 1 sampai 5
            $jumlahTransaksi = rand(1, 5);

            for ($i = 0; $i < $jumlahTransaksi; $i++) {
                // Pilih status secara urut agar logis
                $statusIndex = rand(0, count($statusList)-1);

                Transaksi::create([
                    'user_id' => $user->id,
                    'produk' => $produkList[array_rand($produkList)],
                    'status' => $statusList[$statusIndex],
                    'metode_pembayaran' => $metodeList[array_rand($metodeList)],
                    'total' => $totalList[array_rand($totalList)],
                ]);
            }
        }
    }
}
