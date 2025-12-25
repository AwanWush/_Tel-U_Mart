<<<<<<< Updated upstream
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keranjang Kamu 🛒
        </h2>
    </x-slot>

    <div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">

    @if($items->isEmpty())
        <div class="bg-white p-10 text-center rounded shadow">
            <h3 class="text-lg font-semibold">
                Yah, keranjangmu kosong 😢
            </h3>
            <p class="text-gray-500 mt-2">
                Yuk belanja dulu!
            </p>
        </div>
    @endif

    @foreach($items as $item)
    @php
        $subtotal = $item->produk->harga * $item->quantity;

        $gambar = $item->produk->gambar;
        $imagePath = $gambar
            ? asset(str_starts_with($gambar, 'produk/')
                ? $gambar
                : 'produk/'.$gambar)
            : asset('images/no-image.png');
    @endphp

    <div class="bg-white p-4 mb-4 rounded shadow flex items-center gap-4">

        <input type="checkbox"
            class="item-check w-5 h-5"
            name="cart_items[]"
            value="{{ $item->id }}"
            data-subtotal="{{ $subtotal }}">

        <img
            src="{{ $imagePath }}"
            class="w-20 h-20 object-cover rounded">

        <div class="flex-1">
            <h4 class="font-semibold">{{ $item->produk->nama }}</h4>

            <p class="text-sm text-gray-500">
                Stok: {{ $item->produk->stok }}
            </p>

            <p class="text-sm mt-1">
                Harga:
                <strong>Rp {{ number_format($item->produk->harga) }}</strong>
            </p>
        </div>

        <form method="POST"
            action="{{ route('cart.update', $item->id) }}"
            class="flex flex-col items-center">
            @csrf
            @method('PATCH')

            <input type="number"
                name="quantity"
                value="{{ $item->quantity }}"
                min="1"
                class="w-16 border rounded px-2 py-1 text-center">

            <button class="text-xs text-indigo-600 mt-1">
                Update
            </button>

            <span class="text-xs mt-1">
                Subtotal:<br>
                <strong>Rp {{ number_format($subtotal) }}</strong>
            </span>
        </form>

        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
            @csrf
            @method('DELETE')
            <button class="text-red-500 text-xl">🗑</button>
        </form>

    </div>
    @endforeach
    </div>

    <div class="bg-white p-6 rounded shadow h-fit">
        <h3 class="font-semibold text-lg mb-4">Order Summary</h3>

        <form method="POST" action="{{ route('checkout.selected') }}">
            @csrf

            <div class="flex justify-between mb-2">
                <span>Subtotal</span>
                <span id="subtotalText">Rp 0</span>
            </div>

            <div class="flex justify-between font-bold text-lg">
                <span>Total</span>
                <span id="totalText">Rp 0</span>
            </div>

            <button type="submit"
                    class="w-full mt-5 bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                Checkout
            </button>
        </form>
    </div>

    </div>
    </div>

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
    </script>
</x-app-layout>
=======
<x-layout>
    <div class="max-w-7xl mx-auto px-4 mt-6">
        <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

        @if($items->isEmpty())
            <p class="text-gray-600">Keranjangmu kosong.</p>
            <a href="{{ route('produk.index') }}" class="text-blue-600 hover:underline">Belanja Sekarang</a>
        @else
            <table class="w-full border rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Produk</th>
                        <th class="p-2 text-left">Harga</th>
                        <th class="p-2 text-left">Jumlah</th>
                        <th class="p-2 text-left">Subtotal</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr class="border-t">
                            <td class="p-2 flex items-center gap-2">
                                <img src="{{ $item->produk->gambar ? asset('storage/' . $item->produk->gambar) : asset('images/no-image.png') }}"
                                     alt="{{ $item->produk->nama_produk }}" class="w-12 h-12 object-cover rounded">
                                {{ $item->produk->nama_produk }}
                            </td>
                            <td class="p-2">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                            <td class="p-2">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                           class="w-16 border rounded px-1 py-0.5">
                                    <button type="submit" class="ml-2 px-2 py-1 bg-blue-600 text-white rounded">Update</button>
                                </form>
                            </td>
                            <td class="p-2">
                                Rp {{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}
                            </td>
                            <td class="p-2 text-center">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 text-right font-bold text-lg">
                Total: Rp {{ number_format($items->sum(fn($i) => $i->produk->harga * $i->quantity), 0, ',', '.') }}
            </div>

            <div class="mt-4 text-right">
                <a href="{{ route('checkout.index') }}"
                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Checkout</a>
            </div>
        @endif
    </div>
</x-layout>
>>>>>>> Stashed changes
