<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\RiwayatPembelian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Langkah 1: Direct Checkout
     */
    public function directCheckout(Request $request)
    {
        $produk = Produk::findOrFail($request->product_id);
        $totalHarga = $produk->harga * ($request->qty ?? 1);

        return redirect()->route('payment.method', [
            'type'   => 'delivery',
            'amount' => $totalHarga,
        ]);
    }

    /**
     * Langkah 2: Tampilkan Halaman Metode Pembayaran
     */
    public function showPaymentMethod(Request $request)
    {
        $totalPrice  = $request->query('amount', 0);
        $serviceType = $request->query('type', 'delivery');

        return view('payment.method', compact('totalPrice', 'serviceType'));
    }

    /**
     * Langkah 3: PROSES SIMPAN DINAMIS (Kunci Jawaban Anda)
     */
    public function processCheckout(Request $request)
    {
        // A. Ambil nilai metode dari form (misal: 'cash_cod' atau 'transfer_va')
        $metodePilihan = $request->payment_method;
        
        // B. Buat ID Transaksi Unik agar bisa banyak order
        $unique_order_id = 'TM-' . strtoupper(Str::random(12));

        // C. LOGIKA STATUS (Skenario 1 & 2)
        // Jika COD -> Langsung Sukses
        // Jika Selain itu (Transfer) -> Status Pending
        if ($metodePilihan == 'cash_cod') {
            $statusFinal = 'Sukses';
            $labelMetode = 'Cash On Delivery (COD)';
        } else {
            $statusFinal = 'pending';
            $labelMetode = 'Transfer Virtual Account';
        }

        // D. SIMPAN KE DATABASE
        // Menggunakan create() agar muncul baris baru di riwayat_pembelian
        $riwayat = RiwayatPembelian::create([
            'user_id'           => Auth::id(),
            'id_transaksi'      => $unique_order_id,
            'total_harga'       => $request->total_price ?? 0,
            'status'            => $statusFinal, // Berubah sesuai pilihan user
            'metode_pembayaran' => $labelMetode,
        ]);

        // E. Arahkan ke Halaman Sukses membawa ID Transaksi
        return redirect()->route('order.success', ['order_id' => $unique_order_id]);
    }

    /**
     * Langkah 4: Tampilkan Struk (Invoice)
     */
    public function showSuccess($order_id)
    {
        // Ambil data dari riwayat yang baru saja dibuat
        $riwayat = RiwayatPembelian::where('id_transaksi', $order_id)->firstOrFail();

        return view('order.success', [
            'order_id'       => $riwayat->id_transaksi,
            'status'         => $riwayat->status, // Akan tampil 'Sukses' atau 'pending'
            'paymentMethod'  => $riwayat->metode_pembayaran,
            'total_payment'  => $riwayat->total_harga,
            'order_date'     => $riwayat->created_at->format('d M Y, H:i'),
            'delivery_address' => Auth::user()->alamat_gedung ?? 'Alamat Belum Diatur'
        ]);
    }
}