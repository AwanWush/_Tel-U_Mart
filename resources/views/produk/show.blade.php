<x-layout>

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

        <div class="lg:col-span-2 flex justify-center">
            <div class="sticky top-24 w-full max-w-md">
                <div class="aspect-square bg-white border rounded-2xl overflow-hidden shadow">
                    <img
                        src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/no-image.png') }}"
                        class="w-full h-full object-contain"
                        alt="{{ $produk->nama_produk }}"
                    >

                </div>
            </div>
        </div>

        <div class="lg:col-span-3 space-y-5">

            <h1 class="text-3xl font-bold leading-snug">
                {{ $produk->nama_produk }}
            </h1>

            <x-produk.rating
                :rating="$produk->reviews->avg('rating') ?? 0"
                :count="$produk->reviews->count()" />

            <x-produk.harga
                :harga="$produk->harga"
                :diskon="$produk->persentase_diskon" />

            <x-produk.stok :stok="$produk->stok" />

            <div class="text-sm text-gray-600">
                Tersedia di:
                <span class="font-medium">
                    {{ $produk->marts->pluck('nama_mart')->join(', ') }}
                </span>
            </div>

            @if($produk->variants->count())
                <div>
                    <label class="font-semibold text-sm">Variasi</label>
                    <select class="mt-1 w-full border rounded-xl p-2">
                        @foreach($produk->variants as $variant)
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

        <div class="lg:col-span-2">
            <div class="sticky top-24 bg-white border rounded-2xl p-5 space-y-4 shadow">

                <div>
                    <label class="text-sm font-semibold">Jumlah</label>
                    <input
                        type="number"
                        min="1"
                        value="1"
                        class="mt-1 w-full border rounded-lg p-2"
                    >
                </div>

                <div class="text-sm text-gray-600">
                    Subtotal:
                    <span class="font-bold text-lg text-blue-600">
                        Rp {{ number_format($produk->harga,0,',','.') }}
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $produk->id }}">

                        <button
                            type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition"
                        >
                            + Add to Cart
                        </button>
                    </form>

                    <form method="POST" action="{{ route('wishlist.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $produk->id }}">

                        <button
                            type="submit"
                            class="w-12 h-12 border rounded-xl flex items-center justify-center hover:bg-gray-100"
                        >
                            @include('icons.heart')
                        </button>
                    </form>
                </div>
                <button
                    class="w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition"
                >
                    Checkout
                </button>

            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 mt-16">
        <h2 class="text-xl font-bold mb-4">Produk Serupa</h2>

        @include('produk._recommendation', ['produk' => $rekomendasi])
    </div>

</x-layout>
