<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 py-6">

        {{-- HEADER HALAMAN --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-semibold text-[#5B000B] tracking-tight">
                {{ $kategori->nama_kategori }}
            </h1>
            <p class="text-sm text-black/50 mt-1">
                Menampilkan semua produk dalam kategori ini
            </p>
        </div>

        {{-- GRID PRODUK --}}
        @if ($produk->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($produk as $item)
                    <div
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="group relative bg-white rounded-2xl
                               border border-black/5
                               hover:border-[#E68757]
                               hover:shadow-lg
                               transition overflow-hidden"
                    >
                        <a href="{{ route('produk.show', $item) }}" class="block p-3">

                            {{-- IMAGE --}}
                            <div class="relative rounded-xl overflow-hidden">
                                <img
                                    src="{{ asset(str_replace('produk/', 'produk_assets/', $item->gambar)) }}"
                                    alt="{{ $item->nama_produk }}"
                                    class="w-full h-40 object-cover
                                           transition-transform duration-300
                                           group-hover:scale-105"
                                />
                            </div>

                            {{-- NAMA --}}
                            <h3 class="mt-3 text-sm font-medium text-black line-clamp-2">
                                {{ $item->nama_produk }}
                            </h3>

                            {{-- HARGA --}}
                            <div class="mt-1 text-base font-semibold text-[#930014]">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </div>

                            {{-- STOK --}}
                            <div class="mt-1 text-xs font-semibold flex items-center gap-1
                                {{ $item->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <span class="uppercase tracking-wide">Stok:</span>
                                <span class="text-sm">{{ $item->stok }}</span>
                            </div>

                            {{-- LOKASI / MART --}}
                            <div class="mt-1 text-xs text-black/60 leading-snug">
                                Lokasi:
                                <div>
                                    @foreach ($item->highlightedMarts() as $mart)
                                        <span class="
                                            {{ $mart['is_active']
                                                ? 'text-[#930014] font-semibold'
                                                : 'text-black/50'
                                            }}">
                                            {{ $mart['nama'] }}
                                        </span>@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                            </div>
                        </a>

                        {{-- ACTION BUTTON --}}
                        <div
                            x-show="hover"
                            x-transition.opacity
                            class="absolute top-3 right-3 flex flex-col gap-2"
                        >
                            {{-- WISHLIST --}}
                            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">

                                <button type="submit"
                                    class="w-9 h-9 rounded-full
                                           bg-[#E7BD8A]/80
                                           hover:bg-[#E68757]
                                           border border-[#930014]/30
                                           flex items-center justify-center
                                           text-[#930014]
                                           hover:text-white
                                           transition">
                                    @include('icons.heart')
                                </button>
                            </form>

                            {{-- CART --}}
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">

                                <button type="submit"
                                    class="w-9 h-9 rounded-full
                                           bg-[#DB4B3A]
                                           hover:bg-[#930014]
                                           border border-[#930014]
                                           flex items-center justify-center
                                           text-white
                                           transition">
                                    @include('icons.cart')
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-10">
                {{ $produk->links() }}
            </div>
        @else
            <div class="text-center py-16 text-black/50">
                Produk pada kategori ini belum tersedia.
            </div>
        @endif

    </div>
</x-app-layout>
