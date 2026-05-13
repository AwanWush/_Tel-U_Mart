<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Cart;
use App\Models\Produk;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $orderIdParam = $request->query('order_id');

        // Khusus Token Listrik
        $isToken = $request->query('type') === 'token';
        $nominalToken = $request->query('nominal');

        $status = ($statusParam == 'success' || $statusParam == 'paid')
            ? 'Lunas'
            : 'Belum Bayar';

        return DB::transaction(function () use (
            $request,
            $amount,
            $serviceType,
            $status,
            $customAddress,
            $orderIdParam,
            $isToken,
            $nominalToken
        ) {

            // 2. LOGIKA ANTI-DOUBLE
            $pesanan = RiwayatPembelian::where('id_transaksi', $orderIdParam)->first();
            $directCheckout = session('direct_checkout');

            if (! $pesanan) {
                $pesanan = new RiwayatPembelian;
                $pesanan->id_transaksi = $orderIdParam ?? strtoupper(uniqid('TM-'));
                $pesanan->user_id = Auth::id();
            }

            // =========================
            // DATA PESANAN
            // =========================
            $pesanan->total_harga = $amount;
            $pesanan->status = $status;
            $pesanan->tipe_layanan = $isToken
                ? 'token_listrik'
                : $serviceType;

            // biaya tambahan
            $delivery_fee = $serviceType === 'delivery' ? 3000 : 0;
            $service_fee = 2000;

            // metode pembayaran
            if ($isToken) {
                $pesanan->metode_pembayaran = 'Midtrans Online';
            } else {
                $pesanan->metode_pembayaran = $request->query('payment_method', 'Cash / Tunai');
            }

            // alamat pengiriman
            if ($serviceType === 'delivery') {
                $pesanan->alamat_pengantaran = $customAddress;
            }
            Log::info('Metode disimpan: ' . $pesanan->metode_pembayaran);
Log::info('Query payment_method: ' . $request->query('payment_method'));

            $pesanan->save();

            // 3. SIMPAN DETAIL & KURANGI STOK
            $cekDetail = DB::table('detail_pembelian')
                ->where('riwayat_pembelian_id', $pesanan->id)
                ->exists();

            $nomorTokenGenerated = null;

            if (! $cekDetail) {

                // =========================
                // TOKEN LISTRIK
                // =========================
                if ($isToken) {

                    if ($status === 'Lunas') {

                        $digits = '';

                        for ($i = 0; $i < 20; $i++) {
                            $digits .= mt_rand(0, 9);
                        }

                        $nomorTokenGenerated = implode('-', str_split($digits, 4));

                        DB::table('detail_pembelian')->insert([
                            'riwayat_pembelian_id' => $pesanan->id,
                            'nama_produk' => "Token: $nomorTokenGenerated (Rp " . number_format($nominalToken, 0, ',', '.') . ')',
                            'harga_satuan' => $amount,
                            'jumlah' => 1,
                            'subtotal' => $amount,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                // =========================
                // DIRECT CHECKOUT
                // =========================
                } elseif ($directCheckout) {

                    foreach ($directCheckout['order_data'] as $store) {

                        foreach ($store['items'] as $item) {

                            DB::table('detail_pembelian')->insert([
                                'riwayat_pembelian_id' => $pesanan->id,
                                'nama_produk' => $item['name'],
                                'harga_satuan' => (int) $item['price'],
                                'jumlah' => (int) $item['qty'],
                                'subtotal' => (int) $item['subtotal'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            // Kurangi stok
                            Produk::where('nama_produk', $item['name'])
                                ->decrement('stok', $item['qty']);
                        }
                    }

                    session()->forget('direct_checkout');

                // =========================
                // DARI KERANJANG
                // =========================
                } else {

                    $selectedIds = session('checkout_cart_items', []);

                    $cartItems = Cart::whereIn('id', $selectedIds)
                        ->where('user_id', Auth::id())
                        ->with('produk')
                        ->get();

                    foreach ($cartItems as $item) {

                        DB::table('detail_pembelian')->insert([
                            'riwayat_pembelian_id' => $pesanan->id,
                            'nama_produk' => $item->produk->nama_produk,
                            'harga_satuan' => (int) $item->produk->harga,
                            'jumlah' => $item->quantity,
                            'subtotal' => $item->quantity * $item->produk->harga,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $item->produk->decrement('stok', $item->quantity);
                    }

                    Cart::whereIn('id', $selectedIds)->delete();
                }

                // =========================
                // NOTIFIKASI
                // =========================
                $currentDetails = DB::table('detail_pembelian')
                    ->where('riwayat_pembelian_id', $pesanan->id)
                    ->get()
                    ->map(fn ($d) => [
                        'name' => $d->nama_produk,
                        'qty' => $d->jumlah,
                        'price' => $d->harga_satuan,
                        'subtotal' => $d->subtotal,
                    ]);

                NotificationHelper::send(
                    Auth::user(),
                    'produk',
                    'Pesanan Produk Berhasil 🛒',
                    'Pesanan #' . $pesanan->id_transaksi . ' berhasil dan sedang diproses.',
                    $pesanan
                );
            }

            // =========================
            // DATA UNTUK VIEW
            // =========================
            $order_id = $pesanan->id_transaksi;
            $order_date = $pesanan->created_at->format('d M Y, H:i');

            if ($directCheckout) {

                $order_data = collect($directCheckout['order_data'])
                    ->flatMap(fn ($store) =>
                        collect($store['items'])->map(fn ($item) => [
                            'name' => $item['name'],
                            'qty' => $item['qty'],
                            'price' => $item['price'],
                            'store' => $store['store'],
                        ])
                    )->toArray();

            } else {

                $order_data = DB::table('detail_pembelian')
                    ->where('riwayat_pembelian_id', $pesanan->id)
                    ->get()
                    ->map(fn ($d) => [
                        'name' => $d->nama_produk,
                        'qty' => $d->jumlah,
                        'price' => $d->harga_satuan,
                        'store' => 'T-Mart Point',
                    ])
                    ->toArray();
            }

            return view('order.success', [
                'serviceType' => $serviceType,
                'paymentMethod' => $pesanan->metode_pembayaran,
                'order_id' => $order_id,
                'order_date' => $order_date,
                'status' => $status,
                'order_data' => $order_data,
                'total_payment' => $amount,

                // tambahan
                'delivery_fee' => $delivery_fee,
                'service_fee' => $service_fee,

                'delivery_address' => $pesanan->alamat_pengantaran ?? $customAddress,
                'is_token' => $isToken,
                'nomor_token' => $nomorTokenGenerated,
            ]);
        });
    }
}