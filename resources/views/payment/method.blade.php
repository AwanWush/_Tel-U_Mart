<x-app-layout>
    @php
        $serviceType = request()->query('type', 'delivery');
        $totalPrice  = (int) request()->query('amount', 0);

        if (!function_exists('formatRupiah')) {
            function formatRupiah($angka) {
                return 'Rp ' . number_format($angka, 0, ',', '.');
            }
        }
    @endphp

    <!DOCTYPE html>
    <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Metode Pembayaran</title>

            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

            <style>
                body {
                    font-family: Inter, sans-serif;
                    background: #ffffff;
                }

                :root {
                    --red-main: #dc2626;
                    --red-hover: #b91c1c;
                    --red-soft: #fee2e2;
                    --red-border: #fecaca;
                }

                .card-modern {
                    background: #fff;
                    border-radius: 28px;
                    border: 1px solid rgba(0,0,0,0.05);
                    box-shadow: 0 12px 30px rgba(0,0,0,0.04);
                }

                .method-active {
                    border-color: var(--red-main) !important;
                    background: var(--red-soft);
                    box-shadow: 0 8px 24px rgba(220,38,38,.25);
                }

                .select-method-btn {
                    transition: all .25s ease;
                }

                .select-method-btn:hover {
                    transform: translateY(-2px);
                }
            </style>
        </head>

        <body x-data="{ selected: 'va_online' }">

        <div class="max-w-3xl mx-auto py-8 px-4 pb-40">

            {{-- Breadcrumb --}}
            <nav class="flex text-gray-500 text-sm mb-6">
                <ol class="inline-flex items-center space-x-1">
                    <li><a href="/" class="hover:text-red-600">Home</a></li>
                    <li><span class="mx-2">/</span><a href="/checkout" class="hover:text-red-600">Checkout</a></li>
                    <li><span class="mx-2">/</span><span class="font-semibold text-gray-900">Metode Pembayaran</span></li>
                </ol>
            </nav>

            {{-- Header --}}
            <div class="flex items-center gap-4 mb-8">
                <a href="/checkout"
                class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-100 hover:bg-red-50 transition">
                    <i class="fas fa-arrow-left text-red-600"></i>
                </a>
                <h1 class="text-3xl font-extrabold text-gray-900">Metode Pembayaran</h1>
            </div>

            {{-- Content --}}
            <div class="card-modern p-6">

                <input type="hidden" id="total_amount" value="{{ $totalPrice }}">
                <input type="hidden" id="selected_method_hidden" value="va_online">

                {{-- ONLINE --}}
                <div class="mb-8">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">
                        Pembayaran Online
                    </h2>

                    <div
                        class="select-method-btn p-5 border-2 rounded-2xl cursor-pointer"
                        :class="selected === 'va_online'
                            ? 'method-active border-red-600'
                            : 'border-red-200 bg-red-50/40'"
                        @click="selected='va_online'; document.getElementById('selected_method_hidden').value='va_online'">

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-red-100 text-red-600">
                                    <i class="fas fa-university text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Transfer Virtual Account</p>
                                    <p class="text-xs text-gray-500">BCA • Mandiri • BNI • BRI</p>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-red-600" 
                            x-show="selected==='va_online'"></i>
                        </div>
                    </div>
                </div>

                {{-- CASH --}}
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">
                        Tunai (Cash)
                    </h2>

                    @if($serviceType === 'delivery')
                        {{-- CASH ON DELIVERY --}}
                        <div
                            class="select-method-btn p-5 border-2 rounded-2xl cursor-pointer"
                            :class="selected === 'cash_cod'
                                ? 'method-active border-red-600'
                                : 'border-red-200 bg-red-50/40'"
                            @click="selected='cash_cod'; document.getElementById('selected_method_hidden').value='cash_cod'">

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-red-100 text-red-600">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">Cash On Delivery</p>
                                        <p class="text-xs text-gray-500">Bayar saat pesanan tiba</p>
                                    </div>
                                </div>

                                <i class="fas fa-check-circle text-red-600"
                                x-show="selected === 'cash_cod'"></i>
                            </div>
                        </div>
                    @else
                        {{-- BAYAR DI KASIR --}}
                        <div
                            class="select-method-btn p-5 border-2 rounded-2xl cursor-pointer"
                            :class="selected === 'cash_kasir'
                                ? 'method-active border-red-600'
                                : 'border-red-200 bg-red-50/40'"
                            @click="selected='cash_kasir'; document.getElementById('selected_method_hidden').value='cash_kasir'">

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-red-100 text-red-600">
                                        <i class="fas fa-cash-register"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">Bayar di Kasir</p>
                                        <p class="text-xs text-gray-500">
                                            Lakukan pembayaran saat mengambil pesanan
                                        </p>
                                    </div>
                                </div>

                                <i class="fas fa-check-circle text-red-600"
                                x-show="selected === 'cash_kasir'"></i>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-100 z-50">
            <div class="max-w-3xl mx-auto p-5 space-y-3">

                {{-- Security Info --}}
                <div class="flex items-center gap-2 text-xs text-gray-500 justify-end">
                    <i class="fas fa-shield-alt text-red-600"></i>
                    <span>Pembayaran Anda dilindungi dan terenkripsi</span>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase">Total Pembayaran</p>
                        <p class="text-2xl font-black text-red-600">
                            {{ formatRupiah($totalPrice) }}
                        </p>
                    </div>

                    <button id="payBtn"
                        class="px-8 py-4 rounded-2xl font-bold text-white
                            bg-red-600 hover:bg-red-700
                            shadow-xl shadow-red-300
                            transition active:scale-95">
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </div>
        </div>

        {{-- MIDTRANS --}}
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
                    
            <script>
                document.getElementById('payBtn').addEventListener('click', async () => {

                    const method = document.getElementById('selected_method_hidden').value;
                    const amount = document.getElementById('total_amount').value;

                    // Ambil data dari URL (SAMA seperti kode lama)
                    const params   = new URLSearchParams(window.location.search);
                    const type     = params.get('type') || 'delivery';
                    const product  = params.get('product_id') || '';
                    const qty      = params.get('qty') || '';
                    const address  = params.get('address') || '';

                    const payBtn = document.getElementById('payBtn');
                    payBtn.disabled = true;
                    payBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';

                    // Metode pembayaran cash
                    if (method.includes('cash')) {
                        window.location.href =
                            `/order/success?method=${method}&type=${type}&status=unpaid&amount=${amount}&product_id=${product}&qty=${qty}&address=${encodeURIComponent(address)}`;
                        return;
                    }

                    // Metode pembayaran online
                    try {
                        const res = await fetch("{{ route('payment.snap-token') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                total_amount: amount,
                                product_id: product,
                                qty: qty
                            })
                        });

                        const data = await res.json();

                        window.snap.pay(data.snap_token, {
                            onSuccess: () => {
                                window.location.href =
                                    `/order/success?method=online&status=paid&amount=${amount}&product_id=${product}&qty=${qty}&address=${encodeURIComponent(address)}`;
                            },
                            onPending: () => {
                                window.location.href =
                                    `/order/success?method=online&status=pending&amount=${amount}&product_id=${product}&qty=${qty}&address=${encodeURIComponent(address)}`;
                            },
                            onError: () => {
                                alert('Pembayaran gagal.');
                                location.reload();
                            },
                            onClose: () => {
                                payBtn.disabled = false;
                                payBtn.innerHTML = 'Konfirmasi Pembayaran';
                            }
                        });

                    } catch (e) {
                        alert('Terjadi kesalahan sistem.');
                        location.reload();
                    }
                });
            </script>
        </body>
    </html>
</x-app-layout>