<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 mt-6">
        <x-breadcrumb>
            <a href="/" class="hover:text-blue-600">Home</a>
            <span>›</span>
            <a href="#" class="hover:text-blue-600">
                {{ $produk->kategori?->nama_kategori ?? 'Tanpa Kategori' }}
            </a>
            <span>›</span>
            <span class="font-semibold text-gray-800">
                {{ $produk->nama_produk }}
            </span>
        </x-breadcrumb>
    </div>

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-7 gap-10 mt-8">
        {{-- Bagian Kiri: Gambar Produk --}}
        <div class="lg:col-span-2 flex justify-center">
            <div class="sticky top-24 w-full max-w-md">
                <div class="aspect-square bg-white border rounded-2xl overflow-hidden shadow">
                    <img src="{{ asset(str_replace('produk/', 'produk_assets/', $produk->gambar)) ? asset(str_replace('produk/', 'produk_assets/', $produk->gambar)) : asset('images/no-image.png') }}"
                        class="w-full h-full object-contain" alt="{{ $produk->nama_produk }}">
                </div>
            </div>
        </div>

        {{-- Bagian Tengah: Informasi Produk --}}
        <div class="lg:col-span-3 space-y-5">
            <h1 class="text-3xl font-bold leading-snug">
                {{ $produk->nama_produk }}
            </h1>

            <x-produk.rating :rating="$produk->reviews->avg('rating') ?? 0" :count="$produk->reviews->count()" />

            <x-produk.harga :harga="$produk->harga" :diskon="$produk->persentase_diskon" />

            <x-produk.stok :stok="$produk->stok" />

            <div class="text-sm text-gray-600">
                Tersedia di:
                @foreach ($produk->highlightedMarts() as $mart)
                    <span
                        class="
                            px-2 py-0.5 rounded-full text-xs
                            {{ $mart['is_active'] ? 'bg-red-100 text-red-700 font-semibold' : 'bg-gray-100 text-gray-600' }}">
                        {{ $mart['nama'] }}
                    </span>
                @endforeach
            </div>

            @if ($produk->variants->count())
                <div>
                    <label class="font-semibold text-sm">Variasi</label>
                    <select class="mt-1 w-full border rounded-xl p-2">
                        @foreach ($produk->variants as $variant)
                            <option>{{ $variant->nama }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="pt-5 border-t">
                <h3 class="font-semibold mb-2">Deskripsi Produk</h3>
                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $produk->deskripsi }}
                </p>
            </div>
        </div>

        {{-- Bagian Kanan: Sticky Action Card --}}
        <div class="lg:col-span-2">
            <div class="sticky top-24 bg-white border rounded-2xl p-5 space-y-4 shadow">
                <div>
                    <label class="text-sm font-semibold">Jumlah</label>
                    <input type="number" id="main-qty-input" min="1" value="1" max="{{ $produk->stok }}"
                        class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="text-sm text-gray-600">
                    Subtotal:
                    <span class="font-bold text-lg text-blue-600" id="display-subtotal">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Form Add to Cart --}}
                    <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}"> {{-- GUNAKAN produk_id --}}
                        <input type="hidden" name="qty" value="1" id="cart-qty-hidden">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition font-semibold">
                            + Keranjang
                        </button>
                    </form>
                    </form>

                    {{-- Tombol Wishlist --}}
                    <form method="POST" action="{{ route('wishlist.store') }}">
                        @csrf
                        {{-- Pastikan name adalah produk_id menggunakan huruf 'u' --}}
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                        <button type="submit"
                            class="w-12 h-12 bg-[#DB3B4A] border rounded-xl flex items-center justify-center hover:bg-[#E68757] text-white transition shadow-sm">
                            @include('icons.heart')
                        </button>
                    </form>
                    </form>
                </div>

                {{-- Form Checkout Langsung --}}
                <form action="{{ route('checkout.direct') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $produk->id }}">
                    <input type="hidden" name="qty" value="1" id="checkout-qty-hidden">

                    <button type="submit"
                        class="w-full bg-green-600 text-white py-3 font-bold rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-100">
                        Checkout Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Produk Rekomendasi --}}
    <div class="max-w-7xl mx-auto px-4 mt-16 mb-10">
        <h2 class="text-xl font-bold mb-4">Produk Serupa</h2>
        @include('produk._recommendation', ['produk' => $rekomendasi])
    </div>

    {{-- Script Sinkronisasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyInput = document.getElementById('main-qty-input');
            const cartQtyHidden = document.getElementById('cart-qty-hidden');
            const checkoutQtyHidden = document.getElementById('checkout-qty-hidden');
            const displaySubtotal = document.getElementById('display-subtotal');

            const hargaProduk = {{ $produk->harga }};

            qtyInput.addEventListener('input', function() {
                let val = parseInt(this.value);

                // Validasi input
                if (isNaN(val) || val < 1) val = 1;

                // Update hidden inputs
                cartQtyHidden.value = val;
                checkoutQtyHidden.value = val;

                // Update Tampilan Subtotal secara realtime
                const total = hargaProduk * val;
                displaySubtotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
            });
        });
    </script>
</x-app-layout>
