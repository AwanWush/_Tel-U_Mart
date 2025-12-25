@php
    if (!function_exists('currency')) {
        function currency($amount) {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
    }

    $is_delivery = ($serviceType === 'delivery');

    $payment_labels = [
        'cash_cod' => 'Cash On Delivery (COD)',
        'cash_takeaway' => 'Bayar di Kasir',
        'va_mandiri' => 'Transfer Virtual Account'
    ];
    $display_payment_method = $payment_labels[$paymentMethod] ?? 'Tunai';

    $status_config = [
        'paid' => ['bg' => 'bg-emerald-500', 'label' => 'PAID / LUNAS', 'icon' => 'fa-check-circle'],
        'pending' => ['bg' => 'bg-amber-500', 'label' => 'WAITING PAYMENT', 'icon' => 'fa-clock']
    ];
    $curr = $status_config[$status] ?? $status_config['pending'];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMart - Invoice #{{ $order_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="bg-[#F3F4F6] min-h-screen">

    <nav class="no-print bg-white border-b border-gray-200 px-8 py-4 flex justify-end items-center shadow-sm">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Logged in as</p>
                <p class="text-sm font-black text-slate-800 tracking-tight">Customer User</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-indigo-50 border-2 border-indigo-100 flex items-center justify-center text-indigo-600 transition-all group-hover:bg-indigo-600 group-hover:text-white">
                <i class="fas fa-user text-sm"></i>
            </div>
        </div>
    </nav>

    <main class="p-6 lg:p-10 max-w-[1200px] mx-auto">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <nav class="flex text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-2 no-print">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">Dashboard <i class="fas fa-chevron-right mx-2 text-[8px]"></i></li>
                        <li class="text-indigo-600">Transaction Detail</li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    Invoice <span class="text-indigo-600 font-mono">#{{ $order_id }}</span>
                </h2>
            </div>
            
            <div class="no-print flex items-center gap-3">
                <button onclick="window.print()" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                    <i class="fas fa-print text-xs"></i> Cetak Struk
                </button>
                <a href="/" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <i class="fas fa-plus text-xs"></i> Pesanan Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8">
            {{-- Kolom Kiri --}}
            <div class="col-span-12 lg:col-span-8 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest">Daftar Produk</h3>
                        <span class="px-3 py-1 bg-white border rounded-full text-[10px] font-black text-gray-400 uppercase">{{ count($order_data) }} Item</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <th class="px-8 py-4">Produk</th>
                                    <th class="px-8 py-4 text-center">Qty</th>
                                    <th class="px-8 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @php $subtotal = 0; @endphp
                                @foreach($order_data as $item)
                                @php 
                                    $line_total = $item['qty'] * $item['price']; 
                                    $subtotal += $line_total;
                                @endphp
                                <tr>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                                <i class="fas fa-box text-xs"></i>
                                            </div>
                                            <span class="font-bold text-slate-800">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center font-black text-slate-900">{{ $item['qty'] }}</td>
                                    <td class="px-8 py-5 text-right font-black text-slate-900">{{ currency($line_total) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Pengiriman</h4>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                            <i class="fas fa-map-pin"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $is_delivery ? 'Alamat Pelanggan' : 'Pick-up di Toko' }}</p>
                            <p class="text-sm text-gray-500 mt-1 uppercase italic tracking-tighter">{{ $is_delivery ? $delivery_address : 'Ambil Langsung di Toko' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 {{ $curr['bg'] }} text-white text-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Status Transaksi</p>
                        <div class="flex items-center justify-center gap-3">
                            <i class="fas {{ $curr['icon'] }} text-2xl"></i>
                            <h3 class="text-xl font-black italic">{{ $curr['label'] }}</h3>
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-gray-400 uppercase">Waktu Order</span>
                            <span class="font-black text-slate-800">{{ $order_date }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-gray-400 uppercase">Metode</span>
                            <span class="font-black text-indigo-600">{{ $display_payment_method }}</span>
                        </div>
                        <hr class="border-gray-50">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400 font-medium">Subtotal</span>
                                <span class="font-bold text-slate-800">{{ currency($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-gray-50">
                                <span class="text-lg font-black text-slate-900 italic uppercase">Total</span>
                                <span class="text-2xl font-black text-indigo-600 tracking-tighter">{{ currency($total_payment) }}</span>
                            </div>
                        </div>
                        <a href="/" class="no-print w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-black transition-all text-center block">
                            Kembali ke Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>