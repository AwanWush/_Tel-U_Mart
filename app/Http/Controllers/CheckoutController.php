<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Produk;

use App\Models\RiwayatPembelian;

use Illuminate\Support\Facades\Auth;

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

    // 2. Ambil data dari database lengkap dengan relasi produk
    $cartItems = \App\Models\Cart::whereIn('id', $selectedIds)
                ->where('user_id', auth()->id())
                ->with('produk')
                ->get();

    // 3. Hitung Subtotal
    $subtotal_order = $cartItems->sum(function($item) {
    return $item->produk->harga * $item->quantity;
});

    // 4. SUSUN DATA UNTUK DAFTAR BELANJA (Ini kuncinya!)
    // Pastikan array ini sesuai dengan variabel yang Anda panggil di view
    $order_data = [
        [
            'store' => 'TJ Mart Putra',
            'items' => $cartItems->map(function($item) {
                return [
                    'name'  => $item->produk->nama_produk, // Mengambil nama asli
                    'qty'   => $item->quantity,           // Mengambil jumlah
                    'price' => $item->produk->harga       // Mengambil harga satuan
                ];
            })->toArray()
        ]
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

        $totalPrice  = $request->query('amount', 0);

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

    $statusFinal = ($metodePilihan == 'cash_cod') ? 'unpaid' : ($request->payment_status ?? 'pending');
    $labelMetode = ($metodePilihan == 'cash_cod') ? 'cash_cod' : 'va_online';

    // 1. Simpan transaksi utama
    $riwayat = RiwayatPembelian::create([
        'user_id'           => Auth::id(),
        'id_transaksi'      => $unique_order_id,
        'total_harga'       => $request->total_price,
        'status'            => $statusFinal,
        'metode_pembayaran' => $labelMetode,
    ]);

    // 2. TANGKAP DATA PRODUK DARI KERANJANG
    // Ambil ID item yang dipilih dari input form checkout
    $selectedIds = $request->input('cart_items', []); 
    $cartItems = \App\Models\Cart::whereIn('id', $selectedIds)->with('produk.marts')->get();
    
    $items_detail = $cartItems->map(function($item) {
        return [
            'name'  => $item->produk->nama_produk,
            'qty'   => $item->quantity,
            'price' => $item->produk->harga,
            'store' => $item->produk->marts->first()->nama_mart ?? 'TJ Mart Putra'
        ];
    })->toArray();

    // 3. SIMPAN KE SESSION agar bisa dibaca di showSuccess
    session([
        'last_order_items'   => $items_detail,
        'last_order_address' => $request->address_detail ?? 'Gedung A, Kamar 001',
        'last_order_type'    => $request->service_type ?? 'delivery'
    ]);

    return redirect()->route('order.success', ['order_id' => $unique_order_id]);
}
    /**

     * LANGKAH 4: Struk Akhir

     */

    public function showSuccess($order_id)
{
    $riwayat = RiwayatPembelian::where('id_transaksi', $order_id)->firstOrFail();

    // Mengambil data dari session (Data asli dari transaksi barusan)
    $order_data       = session('last_order_items', []);
    $delivery_address = session('last_order_address', 'Alamat tidak ditemukan');
    $serviceType      = session('last_order_type', 'delivery');

    return view('order.success', [
        'order_id'         => $riwayat->id_transaksi,
        'status'           => $riwayat->status,
        'paymentMethod'    => $riwayat->metode_pembayaran,
        'total_payment'    => $riwayat->total_harga,
        'order_date'       => $riwayat->created_at->format('d M Y, H:i'),
        'delivery_address' => $delivery_address, 
        'order_data'       => $order_data, 
        'serviceType'      => $serviceType,
    ]);
}
    public function directCheckout(Request $request)
    {
        $productId = $request->input('product_id');
        $qty = (int) $request->input('qty', 1);

        if (!$productId) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $produk = Produk::with('marts')->findOrFail($productId);
        $namaToko = $produk->marts->first()->nama_mart ?? 'TJ Mart Putra';

        $order_data = [
            [
                'store' => $namaToko,
                'items' => [
                    [
                        'name' => $produk->nama_produk,
                        'price' => (int) $produk->harga,
                        'qty' => $qty,
                    ]
                ],
            ]
        ];

        $subtotal_order = (int) $produk->harga * $qty;
        $delivery_fee = 0; // Ongkir 0
        $service_fee = 2000; // Layanan 2rb
        $total_payment = $subtotal_order + $service_fee;

        return view('checkout.index', compact(
            'order_data',
            'subtotal_order',
            'delivery_fee',
            'service_fee',
            'total_payment'
        ));
    }
}


