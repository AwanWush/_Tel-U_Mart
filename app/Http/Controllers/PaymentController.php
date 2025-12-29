<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\RiwayatPembelian;
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
        $orderId = 'TM-' . strtoupper(uniqid());
        $totalAmount = (int) $request->total_amount;

        // Ambil data produk (Jika Checkout Langsung)
        $productId = $request->product_id;
        $qty = $request->qty;

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
            // 3. Ambil Snap Token
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'product_id' => $productId, // Kirim balik ke JS
                'qty' => $qty               // Kirim balik ke JS
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}