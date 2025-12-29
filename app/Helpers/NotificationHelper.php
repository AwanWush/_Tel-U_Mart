<?php

namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderUpdateMail;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    public static function send($user, $type, $title, $message, $order = null)
    {
        // 1. Simpan ke Database
        Notification::create([
            'user_id' => $user->id,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'is_read' => false,
        ]);

        // 2. Kirim Email jika ada data order
        if ($order) {
            try {
                // Pastikan relasi 'details' dimuat agar muncul di tabel email
                if (!$order->relationLoaded('details')) {
                    $order->load('details');
                }

                Mail::to($user->email)->send(new OrderUpdateMail($order, $title));
                
                Log::info("Email Berhasil Dikirim ke: " . $user->email);
            } catch (\Exception $e) {
                Log::error("Gagal kirim email: " . $e->getMessage());
            }
        }
    }
}