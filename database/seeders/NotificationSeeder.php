<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) return;

        Notification::insert([
            [
                'user_id' => $user->id,
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pesanan #INV-2025 berhasil dibayar.',
                'type' => 'transaction',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Update Sistem',
                'message' => 'Sistem akan maintenance pukul 23.00 WIB.',
                'type' => 'system',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Informasi Akun',
                'message' => 'Profil kamu berhasil diperbarui.',
                'type' => 'information',
                'is_read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Stok Produk Menipis',
                'message' => 'Produk galon hampir habis.',
                'type' => 'warning',
                'is_read' => false,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Pembayaran Gagal',
                'message' => 'Transaksi gagal, silakan ulangi pembayaran.',
                'type' => 'urgent',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
