<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\RiwayatPembelian;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\NotificationHelper; // Import Helper

class OrderController extends Controller
{
    public function success(Request $request)
    {
        Log::info('Data Success Masuk:', $request->all());

        // 1. Ambil data dari URL
        $amount = (int) $request->query('amount', 0);
        $serviceType = $request->query('type', 'delivery');
        $statusParam = $request->query('status');
        $customAddress = $request->query('address');
        $directProductId = $request->query('product_id');
        $directQty = (int) $request->query('qty', 1);
        $orderIdParam = $request->query('order_id');

        // Khusus Token Listrik
        $isToken = $request->query('type') === 'token';
        $nominalToken = $request->query('nominal');

        $status = ($statusParam == 'success' || $statusParam == 'paid') ? 'Lunas' : 'Belum Bayar';

        return DB::transaction(function () use ($amount, $serviceType, $status, $customAddress, $directProductId, $directQty, $orderIdParam, $isToken, $nominalToken) {

            // 2. LOGIKA ANTI-DOUBLE: Cari transaksi lama atau buat baru
            $pesanan = RiwayatPembelian::where('id_transaksi', $orderIdParam)->first();

            if (!$pesanan) {
                $pesanan = new RiwayatPembelian;
                $pesanan->id_transaksi = $orderIdParam ?? strtoupper(uniqid('TM-'));
                $pesanan->user_id = Auth::id();
            }

            $pesanan->total_harga = $amount;
            $pesanan->status = $status;
            $pesanan->tipe_layanan = $isToken ? 'token_listrik' : $serviceType;
            $pesanan->metode_pembayaran = ($serviceType === 'delivery')
                                          ? ($customAddress ?? Auth::user()->alamat_gedung)
                                          : ($isToken ? 'Midtrans Online' : 'Ambil di Toko (Takeaway)');
            $pesanan->save();

            // 3. Simpan Detail & KURANGI STOK
            $cekDetail = DB::table('detail_pembelian')->where('riwayat_pembelian_id', $pesanan->id)->exists();
            $nomorTokenGenerated = null;
            
            if (!$cekDetail) {
                if ($isToken) {
                    // --- KASUS: PEMBELIAN TOKEN LISTRIK ---
                    if ($status === 'Lunas') {
                        $digits = '';
                        for ($i = 0; $i < 20; $i++) { $digits .= mt_rand(0, 9); }
                        $nomorTokenGenerated = implode('-', str_split($digits, 4));

                        DB::table('detail_pembelian')->insert([
                            'riwayat_pembelian_id' => $pesanan->id,
                            'nama_produk' => "Token: $nomorTokenGenerated (Rp " . number_format($nominalToken, 0, ',', '.') . ")",
                            'harga_satuan' => $amount,
                            'jumlah' => 1,
                            'subtotal' => $amount,
                            'created_at' => now(), 'updated_at' => now(),
                        ]);
                    }
                } elseif (!empty($directProductId) && $directProductId !== 'undefined') {
                    // --- KASUS: CHECKOUT LANGSUNG PRODUK ---
                    $produk = Produk::findOrFail($directProductId);
                    DB::table('detail_pembelian')->insert([
                        'riwayat_pembelian_id' => $pesanan->id,
                        'nama_produk' => $produk->nama_produk,
                        'harga_satuan' => (int) $produk->harga,
                        'jumlah' => $directQty,
                        'subtotal' => $produk->harga * $directQty,
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                    $produk->decrement('stok', $directQty);
                } else {
                    // --- KASUS: DARI KERANJANG ---
                    $cartItems = Cart::where('user_id', Auth::id())->with('produk')->get();
                    foreach ($cartItems as $item) {
                        DB::table('detail_pembelian')->insert([
                            'riwayat_pembelian_id' => $pesanan->id,
                            'nama_produk' => $item->produk->nama_produk,
                            'harga_satuan' => (int) $item->produk->harga,
                            'jumlah' => $item->quantity,
                            'subtotal' => $item->quantity * $item->produk->harga,
                            'created_at' => now(), 'updated_at' => now(),
                        ]);
                        $item->produk->decrement('stok', $item->quantity);
                    }
                    Cart::where('user_id', Auth::id())->delete();
                }

                // 4. KIRIM NOTIFIKASI & EMAIL (Hanya dikirim jika detail baru saja dibuat)
                // Ambil ulang data detail untuk dikirim ke email
                $currentDetails = DB::table('detail_pembelian')
                    ->where('riwayat_pembelian_id', $pesanan->id)
                    ->get()
                    ->map(fn ($d) => [
                        'name' => $d->nama_produk, 
                        'qty' => $d->jumlah, 
                        'price' => $d->harga_satuan, 
                        'subtotal' => $d->subtotal
                    ]);

                NotificationHelper::send(
                    Auth::user(), 
                    'transaction', 
                    'Pesanan Berhasil! 🎉', 
                    'Pesanan #' . $pesanan->id_transaksi . ' telah diterima dan sedang menunggu konfirmasi.',
                    $pesanan // Mengirimkan objek pesanan lengkap untuk kebutuhan Mailable
                );
            }

            // 5. Siapkan data untuk View
            $order_id = $pesanan->id_transaksi;
            $order_date = $pesanan->created_at->format('d M Y, H:i');
            $order_data = DB::table('detail_pembelian')
                ->where('riwayat_pembelian_id', $pesanan->id)
                ->get()
                ->map(fn ($d) => ['name' => $d->nama_produk, 'qty' => $d->jumlah, 'price' => $d->harga_satuan, 'store' => 'T-Mart Point']);

            return view('order.success', [
                'serviceType' => $serviceType,
                'paymentMethod' => $pesanan->metode_pembayaran,
                'order_id' => $order_id,
                'order_date' => $order_date,
                'status' => $status,
                'order_data' => $order_data,
                'total_payment' => $amount,
                'delivery_address' => $pesanan->metode_pembayaran,
                'is_token' => $isToken,
                'nomor_token' => $nomorTokenGenerated
            ]);
        });
    }
}