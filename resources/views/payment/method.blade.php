@php
    // Ambil data dari URL dengan fallback
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
    <title>Pilih Metode Pembayaran</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        body { font-family: Inter, sans-serif; background:#f7f9fb; }
        .select-method-btn { transition: .2s; border-color: #e5e7eb; }
        .method-active { border-color: #4f46e5 !important; background-color: #f5f3ff; }
    </style>
</head>
<body>

<div class="max-w-3xl mx-auto py-8 px-4 pb-32">
    <h1 class="text-3xl font-bold mb-8 text-gray-900">Metode Pembayaran</h1>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <input type="hidden" id="total_amount" value="{{ $totalPrice }}">
        <input type="hidden" id="selected_method_hidden" value="va_online">

        {{-- ONLINE SECTION --}}
        <div class="mb-8">
            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Pembayaran Online</h2>
            
            <div class="select-method-btn p-5 border-2 rounded-2xl cursor-pointer method-active"
                 data-id="va_online">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-university text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Transfer Virtual Account</p>
                            <p class="text-xs text-gray-500">BCA, Mandiri, BNI, BRI (via Midtrans)</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300"></i>
                </div>
            </div>
        </div>

        {{-- CASH SECTION --}}
        <div>
            <h2 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Tunai (Cash)</h2>

            @if($serviceType === 'delivery')
                {{-- Opsi COD untuk Delivery --}}
                <div class="select-method-btn p-5 border-2 rounded-2xl cursor-pointer"
                     data-id="cash_cod">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-truck text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">Cash On Delivery (COD)</p>
                                <p class="text-xs text-gray-500">Bayar tunai saat kurir sampai di lokasi</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300"></i>
                    </div>
                </div>
            @else
                {{-- Opsi Kasir untuk Takeaway --}}
                <div class="select-method-btn p-5 border-2 rounded-2xl cursor-pointer"
                     data-id="cash_kasir">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-cash-register text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">Bayar di Kasir</p>
                                <p class="text-xs text-gray-500">Lakukan pembayaran tunai saat mengambil pesanan</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-300"></i>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- FOOTER FIXED --}}
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg p-5 z-50">
    <div class="flex justify-between items-center max-w-3xl mx-auto">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-tight">Total Pembayaran</p>
            <p class="text-2xl font-black text-red-600">{{ formatRupiah($totalPrice) }}</p>
        </div>
        <button id="payBtn"
                class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all active:scale-95">
            Konfirmasi Pembayaran
        </button>
    </div>
</div>

{{-- MIDTRANS SNAP --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.select-method-btn');
    const hidden  = document.getElementById('selected_method_hidden');
    const payBtn  = document.getElementById('payBtn');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('method-active', 'border-indigo-600'));
            btn.classList.add('method-active', 'border-indigo-600');
            hidden.value = btn.dataset.id;
        });
    });

    payBtn.addEventListener('click', async () => {
        const method = hidden.value;
        const amount = document.getElementById('total_amount').value;

        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...';

        // Logika Pembayaran Tunai (COD atau Kasir)
        if (method.includes('cash')) {
            window.location.href = 
                `/order/success?method=${method}&type={{ $serviceType }}&amount=${amount}&status=unpaid`;
            return;
        }

        // Logika Pembayaran Online Midtrans
        try {
            const res = await fetch("{{ route('payment.snap-token') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ total_amount: amount })
            });

            const data = await res.json();

            window.snap.pay(data.snap_token, {
                onSuccess: (result) => {
                    window.location.href = `/order/success?method=online&status=paid&amount=${amount}`;
                },
                onPending: (result) => {
                    window.location.href = `/order/success?method=online&status=pending&amount=${amount}`;
                },
                onError: () => {
                    alert('Pembayaran gagal, silahkan coba lagi.');
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
});
</script>

</body>
</html>