<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    /**
     * Menampilkan daftar atau status pembayaran
     */
    public function index()
    {
        return view('pembayaran.index');
    }

    /**
     * Menampilkan form untuk membuat pembayaran baru
     */
    public function create()
    {
        return view('pembayaran.create');
    }

    /**
     * METHOD YANG DIPERLUKAN: store
     * Untuk menangani request POST ke /pembayaran
     */
    public function store(Request $request)
    {

        $request->validate([
            'kategori' => 'required|string',
            'keterangan' => 'nullable|string',
            'telepon' => 'nullable|string',
            'bank' => 'nullable|string',
            'norek' => 'nullable|string',
        ]);

        Pembayaran::create([
            'user_id' => auth()->id(),
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'telepon' => $request->telepon,
            'bank' => $request->bank,
            'norek' => $request->norek,
            'aktif' => true,
        ]);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pembayaran->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus');
    }

    public function getSnapToken(Request $request)
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'TM-'.uniqid();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->total_amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name ?? 'Guest',
                'email' => auth()->user()->email ?? 'guest@mail.com',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
