@php
    if (!function_exists('currency')) {
        function currency($amount)
        {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
    }

    $is_delivery = $serviceType === 'delivery';

    // Pemetaan Label Metode Pembayaran agar lebih rapi
    $payment_labels = [
        'cash_cod' => 'Cash On Delivery (COD)',
        'cash_kasir' => 'Bayar di Kasir',
        'va_online' => 'Transfer Virtual Account',
        'va_mandiri' => 'Transfer Virtual Account (Mandiri)',
    ];
    $display_payment_method = $payment_labels[$paymentMethod] ?? 'Tunai';

    // Konfigurasi Status (Warna & Icon)
    $status_config = [
        'paid' => [
            'bg' => 'bg-emerald-500',
            'text' => 'text-emerald-500',
            'label' => 'PAID / LUNAS',
            'icon' => 'fa-check-circle',
        ],
        'pending' => [
            'bg' => 'bg-amber-500',
            'text' => 'text-amber-500',
            'label' => 'WAITING PAYMENT',
            'icon' => 'fa-clock',
        ],
        'unpaid' => [
            'bg' => 'bg-indigo-600',
            'text' => 'text-indigo-600',
            'label' => 'PESANAN DITERIMA',
            'icon' => 'fa-receipt',
        ],
    ];
    $curr = $status_config[$status] ?? $status_config['unpaid'];
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMart - Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

{{-- Letakkan kode ini di bagian atas halaman success sebelum rincian tabel --}}
@if(isset($is_token) && $is_token && $status === 'Lunas')
    <div class="bg-gradient-to-br from-blue-600 to-indigo-800 p-8 rounded-[2.5rem] shadow-2xl text-white mb-8 relative overflow-hidden print:bg-white print:text-black print:shadow-none print:border print:rounded-none">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-blue-200 text-xs font-black uppercase tracking-[0.3em] mb-1 print:text-gray-500">Stroom Token PLN</p>
                    <h2 class="text-4xl font-black tracking-tighter">TRANSAKSI BERHASIL</h2>
                </div>
                <button onclick="window.print()" class="no-print p-3 bg-white/10 hover:bg-white/20 rounded-2xl transition">
                    <i class="fas fa-print mr-2"></i> Cetak Dokumen
                </button>
            </div>

            <div class="bg-black/20 backdrop-blur-md p-6 rounded-3xl border border-white/10 mb-6 print:border-black print:bg-transparent">
                <p class="text-center text-blue-300 text-[10px] font-bold uppercase mb-2 print:text-gray-500">Nomor Token Listrik (20 Digit)</p>
                <div class="flex justify-center items-center gap-4">
                    <span class="text-3xl md:text-5xl font-mono font-black tracking-[0.2em] text-center">
                        {{ $nomor_token }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm opacity-80 print:text-black print:opacity-100">
                <div>
                    <p class="text-[10px] uppercase font-bold">ID Pelanggan</p>
                    <p class="font-bold">{{ Auth::user()->nomor_kamar }} / {{ Auth::user()->alamat_gedung }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] uppercase font-bold">Waktu</p>
                    <p class="font-bold">{{ $order_date }}</p>
                </div>
            </div>
        </div>
        {{-- Background Decoration --}}
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl no-print"></div>
    </div>
@endif

<style>
    @media print {
        .no-print, nav, footer { display: none !important; }
        body { background: white !important; }
        .print\:text-black { color: black !important; }
    }
</style>

<body class="bg-[#F3F4F6] min-h-screen">



    <main class="p-6 lg:p-10 max-w-[1200px] mx-auto">

        {{-- Header: Invoice ID & Action Buttons --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <nav class="flex text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-2">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">Dashboard <i class="fas fa-chevron-right mx-2 text-[8px]"></i>
                        </li>
                        <li class="text-indigo-600">Transaction Detail</li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    Invoice <span class="text-indigo-600 font-mono">#{{ $order_id }}</span>
                </h2>
            </div>

            <div class="no-print flex items-center gap-3">
                <button onclick="window.print()"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all flex items-center gap-2">
                    <i class="fas fa-print text-xs"></i> Cetak Struk
                </button>
                <a href="/"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    <i class="fas fa-plus text-xs mr-2"></i> Pesanan Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8">

            {{-- Kolom Kiri: Items & Address --}}
            <div class="col-span-12 lg:col-span-8 space-y-8">

                {{-- Daftar Produk --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest">Daftar Belanja</h3>
                        <span
                            class="px-3 py-1 bg-white border rounded-full text-[10px] font-black text-gray-400">{{ count($order_data) }}
                            ITEM</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b">
                                    <th class="px-8 py-4">Produk</th>
                                    <th class="px-8 py-4 text-center">Qty</th>
                                    <th class="px-8 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @php $item_subtotal = 0; @endphp
                                @foreach ($order_data as $item)
                                    @php
                                        $line_total = $item['qty'] * $item['price'];
                                        $item_subtotal += $line_total;
                                    @endphp
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                                                    <i class="fas fa-box text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-800">{{ $item['name'] }}</p>
                                                    <p class="text-[10px] text-gray-400 font-bold uppercase">
                                                        <i class="fas fa-store text-[8px] mr-1"></i>
                                                        {{ $item['store'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        </td>
                                        <td class="px-8 py-5 text-center font-bold text-slate-900">{{ $item['qty'] }}
                                        </td>
                                        <td class="px-8 py-5 text-right font-black text-slate-900">
                                            {{ currency($line_total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Informasi Alamat (Sinkron dengan Tipe Pesanan) --}}
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Detail Lokasi</h4>
                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl {{ $is_delivery ? 'bg-red-50 text-red-500' : 'bg-indigo-50 text-indigo-600' }} flex items-center justify-center shrink-0">
                            <i class="fas {{ $is_delivery ? 'fa-map-marker-alt' : 'fa-store-alt' }} text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">
                                {{ $is_delivery ? 'Tujuan Pengiriman' : 'Lokasi Pengambilan Toko' }}</p>
                            <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                                @if ($is_delivery)
                                    {{ $delivery_address ?? 'Alamat tidak terdeteksi' }}
                                @else
                                    <span class="font-semibold text-slate-700">T-Mart.</span><br>
                                    Silahkan tunjukkan nomor Invoice di atas kepada petugas kasir untuk serah terima
                                    pesanan.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Status & Ringkasan Bayar --}}
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Badge Status --}}
                    <div class="p-8 {{ $curr['bg'] }} text-white text-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Status Pembayaran
                        </p>
                        <div class="flex items-center justify-center gap-3">
                            <i class="fas {{ $curr['icon'] }} text-2xl"></i>
                            <h3 class="text-xl font-black italic tracking-tight">{{ $curr['label'] }}</h3>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-gray-400 uppercase">Waktu Transaksi</span>
                                <span class="font-black text-slate-800">{{ $order_date }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-gray-400 uppercase">Metode</span>
                                <span class="font-black text-indigo-600">{{ $display_payment_method }}</span>
                            </div>
                        </div>

                        <hr class="border-gray-50">

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400 font-medium">Subtotal</span>
                                <span class="font-bold text-slate-800">{{ currency($item_subtotal) }}</span>
                            </div>

                            @if ($is_delivery)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 font-medium">Ongkos Kirim</span>
                                    <span class="font-bold text-slate-800">{{ currency($delivery_fee ?? 0) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-sm italic">
                                <span class="text-gray-400 font-medium">Biaya Layanan</span>
                                <span class="font-bold text-slate-800">{{ currency($service_fee ?? 2000) }}</span>
                            </div>

                            {{-- Total Akhir --}}
                            <div class="flex justify-between pt-4 border-t-2 border-dashed border-gray-100 mt-4">
                                <span class="text-lg font-black text-slate-900">TOTAL AKHIR</span>
                                <span class="text-2xl font-black text-red-600 tracking-tighter">
                                    {{ currency($total_payment) }}
                                </span>
                            </div>
                        </div>

                        <a href="/dashboard"
                            class="no-print w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest text-center block hover:bg-black hover:shadow-lg transition-all">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>


</body>

</html>
