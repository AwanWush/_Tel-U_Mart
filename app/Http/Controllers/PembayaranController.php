<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

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
        // 1. Validasi input dari form
        $request->validate([
            'nama_pembayar' => 'required|string|max:255',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Inisialisasi Model
        $pembayaran = new Pembayaran();
        $pembayaran->user_id = Auth::id(); // Mengambil ID user yang sedang login
        $pembayaran->nama_pembayar = $request->nama_pembayar;

        // 3. Proses upload gambar ke folder public/pembayaran_assets
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('pembayaran_assets'), $nama_file);
            $pembayaran->bukti_pembayaran = $nama_file;
        }

        $pembayaran->save();

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('pembayaran.index')->with('success', 'Konfirmasi pembayaran berhasil dikirim!');
    }

    /**
     * Method eksisting Anda untuk integrasi Midtrans Snap
     */
    public function getSnapToken(Request $request)
    {
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $orderId = 'TM-' . uniqid();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $request->total_amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name ?? 'Guest',
                'email'      => auth()->user()->email ?? 'guest@mail.com',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}