<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'keterangan' => 'nullable|string',
            'telepon' => 'nullable|string',
            'bank' => 'nullable|string',
            'norek' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        $saveKeterangan = null;

        switch ($validated['kategori']) {
            case 'E-Wallet':
                $saveKeterangan = ($validated['keterangan'] ?? '-') . 
                                  ' | No: ' . ($validated['telepon'] ?? '-');
                break;

            case 'QRIS':
                $saveKeterangan = 'QRIS';
                break;

            case 'Virtual Account':
                $saveKeterangan = ($validated['bank'] ?? '-') . 
                                  ' | Rek: ' . ($validated['norek'] ?? '-');
                break;

            case 'COD':
                $saveKeterangan = 'COD';
                break;
        }

        MetodePembayaran::create([
            'user_id' => Auth::id(),
            'jenis'   => $validated['kategori'],
            'keterangan' => $saveKeterangan
        ]);

        return redirect()->route('profile.edit', ['tab' => 'pembayaran'])
                 ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Satu method createPayment (gabungan)
     */
    public function createPayment(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat Order ID aman
        $orderId = 'ORDER-' . ($request->transaction_id ?? time()) . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]
        ];

        // Snap Token
        $snapToken = Snap::getSnapToken($params);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function callback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $orderId = $notif->order_id;
        $status  = $notif->transaction_status;
        $fraud   = $notif->fraud_status;

        // Update database (contoh)
        // Transaksi::where('order_id', $orderId)->update([
        //     'status' => $status
        // ]);

        return response()->json(['message' => 'Callback received']);
    }

    public function destroy($id)
    {
        $pay = MetodePembayaran::findOrFail($id);
        $pay->delete();

        return redirect()->route('profile.edit', ['tab' => 'pembayaran'])
                 ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
