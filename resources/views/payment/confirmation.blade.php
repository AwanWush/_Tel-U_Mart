@php
    // --- MOCK DATA ---
    // Total jumlah pesanan yang perlu dibayar
    $total_amount = 155000;

    // Asumsi rute kembali ke halaman checkout
    $checkout_route = route('checkout'); // Ganti dengan rute checkout Anda

    // Struktur data metode pembayaran
    $payment_methods = [
        'virtual_account' => [
            'title' => 'Virtual Account Bank',
            'methods' => [
                ['id' => 'mandiri-va', 'name' => 'Bank Mandiri Virtual Account', 'type' => 'VA', 'bank' => 'Mandiri'],
                ['id' => 'bca-va', 'name' => 'Bank BCA Virtual Account', 'type' => 'VA', 'bank' => 'BCA'],
                ['id' => 'bri-va', 'name' => 'Bank BRI Virtual Account', 'type' => 'VA', 'bank' => 'BRI'],
            ]
        ],
        'e_wallet' => [
            'title' => 'E-Wallet',
            'methods' => [
                ['id' => 'gopay', 'name' => 'GoPay', 'type' => 'QR'],
                ['id' => 'ovo', 'name' => 'OVO', 'type' => 'QR'],
                ['id' => 'dana', 'name' => 'Dana', 'type' => 'QR'],
            ]
        ],
        'cash' => [
            'title' => 'Tunai',
            'methods' => [
                ['id' => 'cod', 'name' => 'Cash On Delivery (COD)', 'type' => 'CASH'],
                ['id' => 'cash-counter', 'name' => 'Cash (Bayar di Kasir)', 'type' => 'CASH'],
            ]
        ]
    ];

    // Tambahkan status yang lebih dinamis untuk tampilan
    $method_status = [
        'mandiri-va' => 'VA aktif, berakhir 01/26',
        'gopay' => 'Terhubung dengan nomor 0812-XXXX-9999',
        // Tambahkan status lain sesuai kebutuhan
    ];
@endphp

<x-app-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    @push('styles')
        {{-- Font Awesome diperlukan untuk ikon --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-100">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-700 mb-6 border-b pb-4">
                Pilih Metode Pembayaran
            </h1>

            {{-- Dalam aplikasi nyata, formulir ini harus menggunakan POST dan diproses di Controller --}}
            {{-- Action ini akan dilempar ke Controller yang akan menyiapkan data order final dan meredirect ke halaman
            Konfirmasi --}}
            <form id="payment-method-form" action="{{ route('payment.process') }}" method="POST">
                @csrf

                <input type="hidden" name="total_amount" value="{{ $total_amount }}">

                <div id="payment-options" class="space-y-6">
                    @foreach ($payment_methods as $group)
                        <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                            <h2 class="bg-gray-50 p-4 text-lg font-bold text-gray-800">{{ $group['title'] }}</h2>
                            <div class="divide-y divide-gray-100">
                                @foreach ($group['methods'] as $method)
                                    <label for="{{ $method['id'] }}"
                                        class="flex items-center p-4 cursor-pointer hover:bg-indigo-50 transition duration-150">
                                        {{-- Nilai yang dikirim harus mencakup ID dan Tipe Pembayaran --}}
                                        <input type="radio" id="{{ $method['id'] }}" name="selected_method"
                                            value="{{ $method['id'] }}" data-type="{{ $method['type'] }}"
                                            class="form-radio h-4 w-4 text-indigo-600 focus:ring-indigo-500 transition duration-150"
                                            required>
                                        <div class="ml-4 flex-1">
                                            <p class="text-base font-semibold text-gray-900">{{ $method['name'] }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $method_status[$method['id']] ?? ($method['type'] === 'VA' ? 'VA belum terdaftar' : ($method['type'] === 'QR' ? 'Belum terhubung' : $method['status'] ?? '')) }}
                                            </p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Total Pembayaran (Footer Fixed) --}}
                <div id="payment-summary"
                    class="fixed inset-x-0 bottom-0 bg-white border-t border-gray-200 shadow-xl p-4 sm:p-6 lg:p-8 z-10">
                    <div class="max-w-3xl mx-auto flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-gray-600">Total Pembayaran:</p>
                            <p class="text-2xl font-extrabold text-indigo-600">
                                Rp {{ number_format($total_amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="w-full sm:w-auto flex space-x-3">
                            {{-- Tombol Kembali --}}
                            <a href="{{ $checkout_route }}"
                                class="flex-1 sm:flex-none text-center py-3 px-6 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-100 transition duration-300">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>

                            {{-- Tombol Konfirmasi Pembayaran --}}
                            <button type="button" onclick="payWithMidtrans()"
                                class="flex-1 sm:flex-none text-center py-3 px-6 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition duration-300 shadow-lg focus:outline-none focus:ring-4 focus:ring-indigo-300 disabled:opacity-50"
                                disabled id="confirm-button">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <div class="pt-20"></div> {{-- Tambahan padding agar footer terlihat di atas konten --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('payment-method-form');
            const confirmButton = document.getElementById('confirm-button');
            const radioButtons = form.querySelectorAll('input[name="selected_method"]');

            // 1. Fungsi untuk mengaktifkan tombol jika ada yang dipilih
            function updateButtonState() {
                const isSelected = Array.from(radioButtons).some(radio => radio.checked);
                confirmButton.disabled = !isSelected;
                if (isSelected) {
                    confirmButton.classList.remove('disabled:opacity-50');
                } else {
                    confirmButton.classList.add('disabled:opacity-50');
                }
            }

            radioButtons.forEach(radio => {
                radio.addEventListener('change', updateButtonState);
            });

            // 2. Fungsi Utama Pembayaran (Dijalankan saat tombol diklik)
            window.payWithMidtrans = function () {
                const selectedRadio = form.querySelector('input[name="selected_method"]:checked');
                const paymentType = selectedRadio.getAttribute('data-type');

                // JIKA PILIH TUNAI/CASH
                if (paymentType === 'CASH') {
                    // Tambahkan token CSRF secara manual jika ingin submit via JS
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    // Buat form bayangan atau langsung submit form yang ada
                    // Pastikan route 'payment.process' menangani logika penyimpanan DB untuk CASH
                    form.submit();
                    return;
                }

                // JIKA PILIH DIGITAL (VA/QR)
                const snapToken = "{{ $snapToken ?? '' }}";

if (snapToken && snapToken !== "") {
window.snap.pay(snapToken, {
    onSuccess: function (result) {
        // Ganti URL agar mengarah ke route success dengan parameter lengkap
        window.location.href = "{{ route('order.success') }}?status=paid" + 
                               "&order_id=" + result.order_id + 
                               "&amount=" + result.gross_amount +
                               "&product_id={{ $productId ?? '' }}" + 
                               "&qty={{ $qty ?? 1 }}";
    },
    onPending: function (result) {
        window.location.href = "{{ route('order.success') }}?status=pending" + 
                               "&order_id=" + result.order_id + 
                               "&amount=" + result.gross_amount +
                               "&product_id={{ $productId ?? '' }}" + 
                               "&qty={{ $qty ?? 1 }}";
    }
});
                } else {
                    alert("Snap Token tidak tersedia. Silakan muat ulang halaman.");
                }
            }; window.payWithMidtrans = function () {
                const selectedRadio = form.querySelector('input[name="selected_method"]:checked');
                const paymentType = selectedRadio.getAttribute('data-type');

                // JIKA PILIH TUNAI/CASH
                if (paymentType === 'CASH') {
                    // Tambahkan token CSRF secara manual jika ingin submit via JS
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    // Buat form bayangan atau langsung submit form yang ada
                    // Pastikan route 'payment.process' menangani logika penyimpanan DB untuk CASH
                    form.submit();
                    return;
                }

                // JIKA PILIH DIGITAL (VA/QR)
                const snapToken = "{{ $snapToken ?? '' }}";

                if (snapToken && snapToken !== "") {
                    window.snap.pay(snapToken, {
                        onSuccess: function (result) {
                            window.location.href = "/order/status/{{ $orderId }}";
                        },
                        onPending: function (result) {
                            window.location.href = "/order/status/{{ $orderId }}";
                        },
                        // ... dst
                    });
                } else {
                    alert("Snap Token tidak tersedia. Silakan muat ulang halaman.");
                }
            };

            updateButtonState();
        });
    </script>

</x-app-layout>