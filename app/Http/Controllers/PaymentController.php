<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\RiwayatPembelian;
use Exception;
use App\Models\TokenTransaction;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // // 2. Generate Order ID Unik
        // $orderId = 'TM-' . strtoupper(uniqid());
        // $totalAmount = (int) $request->total_amount;

        // // Ambil data produk (Jika Checkout Langsung)
        // $productId = $request->product_id;
        // $qty = $request->qty;

        // $params = [
        //     'transaction_details' => [
        //         'order_id' => $orderId,
        //         'gross_amount' => $totalAmount,
        //     ],
        //     'customer_details' => [
        //         'first_name' => auth()->user()->name ?? 'Guest',
        //         'email' => auth()->user()->email ?? 'guest@mail.com',
        //         'phone' => auth()->user()->no_telp ?? '',
        //     ],
        // ];

        // 1. Buat transaksi LOKAL dulu
        $transaksi = TokenTransaction::create([
            'user_id' => Auth::id(),
            'gedung' => Auth::user()->lokasi->nama_lokasi ?? '-',
            'kamar' => Auth::user()->nomor_kamar ?? '-',
            'nama_penghuni' => Auth::user()->name,
            'nomor_hp' => Auth::user()->no_hp ?? null,
            'nominal' => $request->nominal,
            'total_harga' => $request->total_amount,
            'kode_token' => '-', // akan diisi setelah sukses
            'metode' => 'Midtrans',
            'status' => 'Pending',
        ]);

        // 2. Midtrans pakai ID LOKAL
        $params = [
            'transaction_details' => [
                'order_id' => 'TM-' . $transaksi->id,
                'gross_amount' => (int) $request->total_amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        // try {
            // // 3. Ambil Snap Token
            // $snapToken = Snap::getSnapToken($params);
            // return response()->json([
            //     'snap_token' => $snapToken,
            //     'order_id' => $orderId,
            //     'product_id' => $productId, // Kirim balik ke JS
            //     'qty' => $qty               // Kirim balik ke JS
            // ]);
            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'snap_token' => $snapToken,
                'transaction_id' => $transaksi->id, 
            ]);
        // } catch (Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
    }
}