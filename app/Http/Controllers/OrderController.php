<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function success(Request $request)
    {
        // Ambil dari query string
        $serviceType   = $request->query('type', 'delivery');
        $paymentMethod = $request->query('method', 'cash_cod');
        $status        = $request->query('status', 'pending');
        $amount        = (int) $request->query('amount', 0);

        // Data tambahan agar blade tidak error
        $order_id = strtoupper(uniqid('TM-'));
        $order_date = now()->format('d M Y, H:i');
        $total_payment = $amount;

        $delivery_address = 'Jl. Contoh Alamat No. 123, Bandung';

        // Dummy produk (karena belum pakai database)
        $order_data = [
            [
                'name'  => 'Produk Pesanan',
                'qty'   => 1,
                'price' => $amount
            ]
        ];

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
