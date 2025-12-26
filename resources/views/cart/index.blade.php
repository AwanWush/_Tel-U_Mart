<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keranjang Kamu 🛒
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">

                @if (!$cart || $cart->items->isEmpty())
                    <div class="bg-white p-10 text-center rounded shadow">
                        <h3 class="text-lg font-semibold">Yah, keranjangmu kosong 😢</h3>
                        <p class="text-gray-500 mt-2">Yuk belanja dulu!</p>
                    </div>
                @else
                    @foreach ($cart->items as $item)
                        @php
                            $subtotal = $item->produk->harga * $item->quantity;

                            $gambar = $item->produk->gambar;
                            $imagePath = asset('produk_assets/' . basename($gambar));
                        @endphp




                        <div class="bg-white p-4 mb-4 rounded shadow flex items-center gap-4 border border-gray-100">
                            <input type="checkbox" class="item-check w-5 h-5 accent-red-600 cursor-pointer"
                                name="cart_items[]" value="{{ $item->id }}" data-price="{{ $item->produk->harga }}"
                                data-qty="{{ $item->quantity }}">

                            <div
                                class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                                <img src="{{ $imagePath }}" alt="{{ $item->produk->nama_produk }}"
                                    class="w-full h-full object-cover" />

                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-800 truncate">{{ $item->produk->nama_produk }}</h4>
                                <p class="text-xs text-gray-400">Stok: {{ $item->produk->stok }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">
                                    Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex flex-col items-center gap-1">
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    max="{{ $item->produk->stok }}"
                                    class="qty-input w-16 border rounded px-2 py-1 text-center text-sm focus:ring-1 focus:ring-red-500">

                                <div class="text-center mt-2">
                                    <span class="text-[10px] text-gray-400 block uppercase">Subtotal</span>
                                    <strong class="item-subtotal text-sm text-red-600">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </strong>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('cart.remove', $item->id) }}"
                                onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-600 transition p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="bg-white p-6 rounded shadow h-fit sticky top-6">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Ringkasan Belanja</h3>

                <form method="POST" action="{{ route('checkout.selected') }}">
                    @csrf
                    <div id="hidden-checkout-inputs"></div>

                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Total Harga</span>
                        <span id="subtotalText" class="font-medium">Rp 0</span>
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between font-bold text-xl text-gray-900">
                        <span>Total Bayar</span>
                        <span id="totalText" class="text-red-600">Rp 0</span>
                    </div>

                    <button type="submit" id="checkoutBtn" disabled
                        class="w-full mt-6 bg-gray-300 text-white py-3 rounded-lg font-bold transition-all duration-300 cursor-not-allowed">
                        Checkout (0)
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.item-check');
            const qtyInputs = document.querySelectorAll('.qty-input');
            const subtotalText = document.getElementById('subtotalText');
            const totalText = document.getElementById('totalText');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const hiddenContainer = document.getElementById('hidden-checkout-inputs');

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            function hitungTotal() {
                let total = 0;
                let count = 0;
                hiddenContainer.innerHTML = '';

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        const price = parseInt(cb.dataset.price);
                        const qty = parseInt(cb.dataset.qty);
                        total += price * qty;
                        count++;

                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'cart_items[]';
                        hiddenInput.value = cb.value;
                        hiddenContainer.appendChild(hiddenInput);
                    }
                });

                subtotalText.innerText = formatRupiah(total);
                totalText.innerText = formatRupiah(total);

                if (count > 0) {
                    checkoutBtn.disabled = false;
                    checkoutBtn.className =
                        "w-full mt-6 bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-bold transition-all cursor-pointer";
                    checkoutBtn.innerText = `Checkout (${count})`;
                } else {
                    checkoutBtn.disabled = true;
                    checkoutBtn.className =
                        "w-full mt-6 bg-gray-300 text-white py-3 rounded-lg font-bold cursor-not-allowed";
                    checkoutBtn.innerText = 'Checkout (0)';
                }
            }

            qtyInputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    let val = parseInt(e.target.value);
                    if (isNaN(val) || val < 1) {
                        val = 1;
                        e.target.value = 1;
                    }

                    const parent = e.target.closest('.bg-white');
                    const cb = parent.querySelector('.item-check');
                    const subtotalEl = parent.querySelector('.item-subtotal');
                    const price = parseInt(cb.dataset.price);

                    cb.dataset.qty = val;
                    subtotalEl.innerText = formatRupiah(price * val);

                    hitungTotal();
                });
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', hitungTotal);
            });
        });
    </script>
</x-app-layout>
