<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\RiwayatPembelian; // Pastikan Model ini diimport
use Exception;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Generate Order ID Unik
        $orderId = 'TM-' . uniqid();
        $totalAmount = (int) $request->total_amount;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name ?? 'Guest',
                'email' => auth()->user()->email ?? 'guest@mail.com',
                'phone' => auth()->user()->no_telp ?? '',
            ],
        ];

        try {
            // 3. Ambil Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 4. LOGIKA PENGGABUNGAN: Simpan ke RiwayatPembelian
            // Kita simpan dulu dengan status 'pending' atau 'menunggu pembayaran'
            RiwayatPembelian::create([
                'user_id' => auth()->id(),
                'id_transaksi' => $orderId,
                'total_harga' => $request->total_amount,
                'status' => 'pending',
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}