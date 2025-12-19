<x-layout>

    {{-- BREADCRUMB --}}
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

    {{-- GRID UTAMA --}}
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-7 gap-8 mt-6">

        {{-- GAMBAR --}}
        <div class="md:col-span-2 flex justify-center">
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

        {{-- INFO PRODUK --}}
        <div class="md:col-span-3 space-y-5">

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

        {{-- ACTION --}}
        <div class="md:col-span-2">
            <div class="sticky top-24 bg-white border rounded-2xl p-4 space-y-4 shadow">

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

                <div class="flex gap-3">
                    <button class="flex-1 bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700">
                        + Add to Cart
                    </button>

                    <button class="w-12 h-12 border rounded-xl flex items-center justify-center hover:bg-gray-100">
                        @include('icons.heart')
                    </button>
                </div>

                <button class="w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700">
                    Checkout
                </button>

            </div>
        </div>
    </div>

    {{-- REKOMENDASI --}}
    <div class="max-w-7xl mx-auto px-4 mt-14">
        <h2 class="text-xl font-bold mb-4">Produk Serupa</h2>

        @include('produk._recommendation', ['produk' => $rekomendasi])
    </div>

</x-layout>
