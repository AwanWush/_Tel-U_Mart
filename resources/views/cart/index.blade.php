<x-layout>
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
            Keranjang Kamu 🛒
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('checkout.selected') }}">
        @csrf

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- CART ITEMS --}}
                <div class="lg:col-span-2">

                    @if($items->isEmpty())
                        <div class="bg-white dark:bg-white-800 p-10 text-center rounded shadow">
                            <h3 class="text-lg font-semibold">
                                Yah, keranjangmu kosong 😢
                            </h3>
                            <p class="text-black-500 mt-2">
                                Yuk belanja dulu!
                            </p>
                        </div>
                    @endif

                    @foreach($items as $item)
                        @php
                            $subtotal = $item->produk->harga * $item->qty;
                        @endphp

                        <div class="bg-white dark:bg-gray-800 p-4 mb-4 rounded shadow flex items-center gap-4">

                            <input type="checkbox"
                                   class="item-check w-5 h-5"
                                   name="cart_items[]"
                                   value="{{ $item->id }}"
                                   data-subtotal="{{ $subtotal }}">

                            <img src="{{ asset('storage/'.$item->produk->image) }}"
                                 class="w-20 h-20 object-cover rounded">

                            <div class="flex-1">
                                <h4 class="font-semibold">
                                    {{ $item->produk->nama }}
                                </h4>

                                <p class="text-sm text-gray-500">
                                    Stok: {{ $item->produk->stok }}
                                </p>

                                <p class="text-sm mt-1">
                                    Harga:
                                    <strong>Rp {{ number_format($item->produk->harga) }}</strong>
                                </p>

                                @if($item->produk->stok == 0)
                                    <p class="text-red-500 text-sm mt-1">
                                        Stok produk habis
                                    </p>
                                @endif
                            </div>

                            {{-- QTY UPDATE (TIDAK DALAM FORM BESAR) --}}
                            <form method="POST"
                                  action="{{ route('cart.update', $item->id) }}"
                                  class="flex flex-col items-center">
                                @csrf
                                @method('PATCH')

                                <input type="number"
                                       name="qty"
                                       value="{{ $item->qty }}"
                                       min="1"
                                       class="w-16 border rounded px-2 py-1 text-center">

                                <button class="text-xs text-indigo-600 mt-1">
                                    Update
                                </button>

                                <span class="text-xs text-white-500 mt-1">
                                    Subtotal:<br>
                                    <strong>Rp {{ number_format($subtotal) }}</strong>
                                </span>
                            </form>

                            {{-- REMOVE --}}
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xl">
                                    🗑
                                </button>
                            </form>

                        </div>
                    @endforeach
                </div>

                {{-- ORDER SUMMARY --}}
                <div class="bg-white dark:bg-white-800 p-6 rounded shadow h-fit">
                    <h3 class="font-semibold text-lg mb-4">
                        Order Summary
                    </h3>

                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotalText">Rp 0</span>
                    </div>

                    <div class="flex justify-between mb-2 text-sm text-black-500">
                        <span>PPN</span>
                        <span>Include</span>
                    </div>

                    <div class="flex justify-between mb-2 text-sm text-black-500">
                        <span>Ongkir</span>
                        <span>Rp 0</span>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span id="totalText">Rp 0</span>
                    </div>

                    <button type="submit"
                            class="w-full mt-5 bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                        Checkout
                    </button>
                </div>

            </div>
        </div>
    </form>

    {{-- SCRIPT --}}
    <script>
        const checkboxes = document.querySelectorAll('.item-check');
        const subtotalText = document.getElementById('subtotalText');
        const totalText = document.getElementById('totalText');

        function hitungTotal() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.dataset.subtotal);
                }
            });
            subtotalText.innerText = 'Rp ' + total.toLocaleString('id-ID');
            totalText.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        checkboxes.forEach(cb => cb.addEventListener('change', hitungTotal));

        document.querySelector('form').addEventListener('submit', function (e) {
            if (document.querySelectorAll('.item-check:checked').length === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 produk untuk checkout');
            }
        });
    </script>

</x-app-layout>
</x-layout>
