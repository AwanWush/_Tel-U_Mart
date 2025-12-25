<!-- <div class="max-w-7xl mx-auto px-4 pt-4 pb-8">

</div> -->
@props(['kategoriProduk'])

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8">

@foreach ($kategoriProduk as $kategori)
    @php
        $produkList = $kategori->produkAktif;
        $hasMore = $produkList->count() > 12;
        $produkTampil = $produkList->take(12);
    @endphp

    @if ($produkTampil->count())
        {{-- Judul kategori --}}
        <div class="flex items-center justify-between mb-2 mt-6">
            <h2 class="text-2xl font-bold">
                {{ $kategori->nama_kategori }}
            </h2>

            @if ($hasMore)
                <a href="{{ route('produk.by-kategori', $kategori) }}"
                   class="text-blue-600 hover:underline font-medium text-sm">
                    See more →
                </a>
            @endif
        </div>

        {{-- Grid produk --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($produkTampil as $produk)
                <a href="{{ route('produk.show', $produk) }}"
                   class="group relative block bg-white p-3 rounded-xl shadow hover:shadow-lg transition">

                    {{-- Wishlist & Cart --}}
                    <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                        <button class="bg-white p-1 rounded-full shadow hover:bg-red-100">
                            @include('icons.heart')
                        </button>
                        <button class="bg-white p-1 rounded-full shadow hover:bg-blue-100">
                            @include('icons.cart')
                        </button>
                    </div>

                    {{-- Gambar --}}
                    <img src="{{ asset(str_replace('produk/', 'produk_assets/', $produk->gambar)) }}"
                         class="w-full h-40 object-cover rounded-lg" />

                    {{-- Nama --}}
                    <h3 class="mt-2 text-sm font-semibold line-clamp-2">
                        {{ $produk->nama_produk }}
                    </h3>

                    {{-- Diskon --}}
                    @if ($produk->persentase_diskon)
                        <div class="text-red-500 font-bold text-sm">
                            Diskon {{ $produk->persentase_diskon }}%
                        </div>
                    @endif

                    {{-- Harga --}}
                    <div class="text-lg font-bold text-blue-600">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>

                    {{-- Stok --}}
                    <div class="text-xs mt-1
                        {{ $produk->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                        Stok: {{ $produk->stok }}
                    </div>

                    {{-- Mart --}}
                    <div class="text-xs mt-1 text-gray-500">
                        @foreach ($produk->highlightedMarts() as $mart)
                            <span class="{{ $mart['is_active'] ? 'text-red-600 font-semibold' : '' }}">
                                {{ $mart['nama'] }}
                            </span>@if(!$loop->last), @endif
                        @endforeach
                    </div>

                </a>
            @endforeach
        </div>
    @endif
@endforeach

</div>