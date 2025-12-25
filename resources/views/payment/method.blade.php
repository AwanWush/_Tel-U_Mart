@php
    $serviceType = request()->query('type', $serviceType ?? 'delivery');
    $totalPrice  = request()->query('amount', $totalPrice ?? 0);

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
        .select-method-btn { transition: .2s; }
    </style>
</head>
<body>

<div class="max-w-7xl mx-auto py-8 px-4 pb-32">
    <h1 class="text-3xl font-bold mb-8">Metode Pembayaran</h1>

    <div class="bg-white p-6 rounded-2xl shadow border">
        <input type="hidden" id="total_amount" value="{{ $totalPrice }}">
        <input type="hidden" id="selected_method_hidden" value="va_mandiri">

        {{-- ONLINE --}}
        <h2 class="font-bold mb-3">Pembayaran Online</h2>

        <div class="select-method-btn p-5 border-2 rounded-xl cursor-pointer mb-4"
             data-id="va_mandiri">
            <input type="radio" checked class="hidden">
            <div class="flex items-center gap-4">
                <i class="fas fa-university text-xl"></i>
                <div>
                    <p class="font-bold">Transfer Virtual Account</p>
                    <p class="text-sm text-gray-500">BCA, Mandiri, BNI</p>
                </div>
            </div>
        </div>

        {{-- CASH --}}
        <h2 class="font-bold mt-6 mb-3">Cash</h2>

        @if($serviceType === 'delivery')
            <div class="select-method-btn p-5 border-2 rounded-xl cursor-pointer"
                 data-id="cash_cod">
                <input type="radio" class="hidden">
                <div class="flex items-center gap-4">
                    <i class="fas fa-truck"></i>
                    <div>
                        <p class="font-bold">Cash On Delivery</p>
                        <p class="text-sm text-gray-500">Bayar di tempat</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- FOOTER --}}
<div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow p-4">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        <div>
            <p class="text-sm text-gray-500">Total</p>
            <p class="text-2xl font-bold text-indigo-600">{{ formatRupiah($totalPrice) }}</p>
        </div>
        <button id="payBtn"
                class="px-10 py-3 bg-indigo-600 text-white rounded-xl font-bold">
            Konfirmasi Pembayaran
        </button>
    </div>
</div>

{{-- MIDTRANS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.select-method-btn');
    const hidden  = document.getElementById('selected_method_hidden');
    const payBtn  = document.getElementById('payBtn');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('border-indigo-600'));
            btn.classList.add('border-indigo-600');
            hidden.value = btn.dataset.id;
        });
    });

    payBtn.addEventListener('click', async () => {

        const method = hidden.value;
        const amount = document.getElementById('total_amount').value;

        payBtn.disabled = true;
        payBtn.innerHTML = 'Memproses...';

        // ================= CASH =================
        if (method.includes('cash')) {
            window.location.href =
                `/order/success?method=${method}&type={{ $serviceType }}&amount=${amount}&status=paid`;
            return;
        }

        // ================= MIDTRANS =================
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
                onSuccess: () => {
                    window.location.href =
                        `/order/success?method=${method}&type={{ $serviceType }}&amount=${amount}&status=paid`;
                },
                onPending: () => {
                    window.location.href =
                        `/order/success?method=${method}&type={{ $serviceType }}&amount=${amount}&status=pending`;
                },
                onError: () => location.reload(),
                onClose: () => {
                    payBtn.disabled = false;
                    payBtn.innerHTML = 'Konfirmasi Pembayaran';
                }
            });

        } catch (e) {
            alert('Terjadi kesalahan');
            location.reload();
        }
    });
});
</script>

</body>
</html>
