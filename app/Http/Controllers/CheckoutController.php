<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CheckoutController extends Controller
{
    public function directCheckout(Request $request)
    {
        $produk = Produk::findOrFail($request->product_id);
        $qty = $request->qty ?? 1;

        $totalHarga = $produk->harga * $qty;

        return redirect()->route('payment.method', [
            'type'   => 'delivery',
            'amount' => $totalHarga
        ]);
    }

    public function showPaymentMethod(Request $request)
    {
        $totalPrice  = $request->query('amount', 0);
        $serviceType = $request->query('type', 'delivery');

        return view('payment.method', compact('totalPrice', 'serviceType'));
    }

    public function showSuccess(Request $request)
    {
        $serviceType   = $request->query('type', 'delivery');
        $paymentMethod = $request->query('method', 'cash_cod');
        $status        = $request->query('status', 'pending');
        $amount        = (int) $request->query('amount', 0);

        $order_id   = strtoupper(uniqid('TM-'));
        $order_date = now()->format('d M Y, H:i');
        $delivery_address = 'Jl. Contoh Alamat No. 123, Bandung';

        $order_data = [
            [
                'name'  => 'Produk Pesanan',
                'qty'   => 1,
                'price' => $amount
            ]
        ];

        $total_payment = $amount;

        return view('order.success', compact(
    'serviceType',
    'paymentMethod',
    'status',
    'order_id',
    'order_date',
    'order_data',
    'total_payment',
    'delivery_address'
));
    }
}
