<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\RiwayatPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil ID item yang dipilih dari Cart
        $selectedIds = $request->input('cart_items', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.index')->with('error', 'Pilih produk terlebih dahulu!');
        }

        session(['checkout_cart_items' => $selectedIds]);

        // 2. Ambil data dari database lengkap dengan relasi produk
        $cartItems = \App\Models\Cart::whereIn('id', $selectedIds)
            ->where('user_id', Auth::id())
            ->with('produk')
            ->get();

        // 3. Hitung Subtotal
        $subtotal_order = $cartItems->sum(function ($item) {
            return $item->produk->harga * $item->quantity;
        });

        // 4. SUSUN DATA UNTUK DAFTAR BELANJA (Ini kuncinya!)
        // Pastikan array ini sesuai dengan variabel yang Anda panggil di view
        $order_data = [
            [
                'store' => 'TJ Mart Putra',
                'items' => $cartItems->map(function ($item) {
                    return [
                        'name' => $item->produk->nama_produk, // Mengambil nama asli
                        'qty' => $item->quantity,           // Mengambil jumlah
                        'price' => $item->produk->harga,       // Mengambil harga satuan
                    ];
                })->toArray(),
            ],
        ];

        $delivery_fee = 0;
        $service_fee = 2000;
        $total_payment = $subtotal_order + $service_fee;

        return view('checkout.index', compact(
            'order_data',
            'subtotal_order',
            'delivery_fee',
            'service_fee',
            'total_payment'
        ));
    }

    /**
     * LANGKAH 2: Tampilkan Halaman Metode Pembayaran

     * (Dipanggil oleh JavaScript payBtn.onclick di halaman checkout)
     */
    public function showPaymentMethod(Request $request)
    {

        // Mengambil parameter dari URL hasil redirect JS

        $totalPrice = $request->query('amount', 0);

        $serviceType = $request->query('type', 'delivery');

        return view('payment.method', compact('totalPrice', 'serviceType'));

    }

    /**
     * LANGKAH 3: Proses Simpan ke Database (Tabel riwayat_pembelian)
     */
    public function processCheckout(Request $request)
{
    $metodePilihan = $request->payment_method;
    $unique_order_id = 'TM-' . strtoupper(Str::random(12));

    $statusFinal = ($metodePilihan == 'cash_cod') ? 'unpaid' : 'pending';
    $labelMetode = ($metodePilihan == 'cash_cod') ? 'cash_cod' : 'va_online';

    // 1️⃣ Ambil item cart yang dipilih
    $selectedIds = $request->input('cart_items', []);

    $cartItems = \App\Models\Cart::whereIn('id', $selectedIds)
        ->where('user_id', Auth::id())
        ->with('produk')
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')
            ->with('error', 'Cart kosong');
    }

    // 2️⃣ HITUNG TOTAL HARGA DI BACKEND (WAJIB)
    $subtotal = $cartItems->sum(function ($item) {
        return $item->produk->harga * $item->quantity;
    });

    $service_fee = 2000;
    $delivery_fee = 0;

    $total_harga = $subtotal + $service_fee + $delivery_fee;

    // 3️⃣ SIMPAN RIWAYAT PEMBELIAN
    $riwayat = RiwayatPembelian::create([
        'user_id' => Auth::id(),
        'id_transaksi' => $unique_order_id,
        'total_harga' => $total_harga, // ✅ SUDAH AMAN
        'status' => $statusFinal,
        'metode_pembayaran' => $labelMetode,
    ]);

    // 4️⃣ SIMPAN DETAIL PEMBELIAN
    foreach ($cartItems as $item) {
        DB::table('detail_pembelian')->insert([
            'riwayat_pembelian_id' => $riwayat->id,
            'nama_produk' => $item->produk->nama_produk,
            'harga_satuan' => $item->produk->harga,
            'jumlah' => $item->quantity,
            'subtotal' => $item->produk->harga * $item->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kurangi stok
        $item->produk->decrement('stok', $item->quantity);
    }

    // 5️⃣ HAPUS CART
    \App\Models\Cart::whereIn('id', $selectedIds)->delete();

    return redirect()->route('order.success', [
        'order_id' => $unique_order_id
    ]);
}

    /**
     * LANGKAH 4: Struk Akhir
     */
    // public function showSuccess($order_id)
    // {
    //     $riwayat = RiwayatPembelian::where('id_transaksi', $order_id)->firstOrFail();

    //     // Mengambil data dari session (Data asli dari transaksi barusan)
    //     $order_data = session('last_order_items', []);
    //     $delivery_address = session('last_order_address', 'Alamat tidak ditemukan');
    //     $serviceType = session('last_order_type', 'delivery');

    //     return view('order.success', [
    //         'order_id' => $riwayat->id_transaksi,
    //         'status' => $riwayat->status,
    //         'paymentMethod' => $riwayat->metode_pembayaran,
    //         'total_payment' => $riwayat->total_harga,
    //         'order_date' => $riwayat->created_at->format('d M Y, H:i'),
    //         'delivery_address' => $delivery_address,
    //         'order_data' => $order_data,
    //         'serviceType' => $serviceType,
    //     ]);
    // }

    // public function directCheckout(Request $request)
    // {
    //     $productId = $request->product_id;
    //     $qty = $request->qty ?? 1;

    //     $produk = \App\Models\Produk::findOrFail($productId);

    //     // ===== STRUKTUR SESUAI BLADE =====
    //     $order_data = [
    //         [
    //             'store' => $produk->mart->nama_mart ?? 'TJ Mart',
    //             'items' => [
    //                 [
    //                     'name' => $produk->nama_produk,
    //                     'qty' => $qty,
    //                     'price' => $produk->harga,
    //                 ]
    //             ]
    //         ]
    //     ];
    //     $order_data = [
    //         [
    //             'name'  => $produk->nama_produk,
    //             'qty'   => $qty,
    //             'price' => $produk->harga,
    //             'store' => $produk->mart->nama_mart ?? 'TJ Mart',
    //         ]
    //     ];


    //     // ===== PERHITUNGAN =====
    //     $subtotal_order = $produk->harga * $qty;
    //     $delivery_fee   = 0;        // default, JS yang toggle
    //     $service_fee    = 2000;     // sesuai blade
    //     $total_payment  = $subtotal_order + $service_fee + $delivery_fee;

    //     session([
    //         'direct_checkout' => [
    //             'product_id' => $produk->id,
    //             'qty' => $qty,
    //         ]
    //     ]);

    //     return view('checkout.index', compact(
    //         'order_data',
    //         'subtotal_order',
    //         'delivery_fee',
    //         'service_fee',
    //         'total_payment'
    //     ));
    // }

    public function directCheckout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'qty' => 'required|integer|min:1',
        ]);

        
        $produk = Produk::with('marts')->findOrFail($request->product_id);
        $qty = $request->qty;

        $storeName = activeMart()?->nama_mart
            ?? $produk->marts->first()?->nama_mart
            ?? 'TJ Mart';

        // FORMAT 1 (nested store -> items)
        $order_data = [
            [
                'store' => $storeName,
                'items' => [
                    [
                        'name'  => $produk->nama_produk,
                        'qty'   => $qty,
                        'price' => $produk->harga,
                        'subtotal' => $produk->harga * $qty,
                    ]
                ]
            ]
        ];

        // ATAU FORMAT 2 (flat)
        /*
        $order_data = [
            [
                'name'  => $produk->nama_produk,
                'qty'   => $qty,
                'price' => $produk->harga,
                'store' => $produk->mart->nama_mart ?? 'TJ Mart',
            ]
        ];
        */

        // lanjut ke proses checkout
        // ===== PERHITUNGAN =====
        $subtotal_order = $produk->harga * $qty;
        $delivery_fee   = 0;        // default, JS yang toggle
        $service_fee    = 2000;     // sesuai blade
        $total_payment  = $subtotal_order + $service_fee + $delivery_fee;

        session([
            'direct_checkout' => [
                'order_data' => $order_data,
                'summary' => [
                    'subtotal' => $subtotal_order,
                    'service_fee' => $service_fee,
                    'delivery_fee' => $delivery_fee,
                    'total' => $total_payment,
                ]
            ]
        ]);

        return view('checkout.index', compact(
            'order_data',
            'subtotal_order',
            'delivery_fee',
            'service_fee',
            'total_payment'
        ));

        // return view('checkout.index', compact('order_data'));
    }
}
