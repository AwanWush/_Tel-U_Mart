@props(['kategoriProduk'])

<div class="max-w-screen-2xl mx-auto px-4 pt-4 pb-8">

    @foreach ($kategoriProduk as $kategori)
        @php
            $activeMart = activeMart();

            $produkList = $kategori->produkAktifByMart($activeMart)->get();

            $produkTampil = $produkList->take(6);
            $hasMore = $produkList->count() > 6;
        @endphp

        @if ($produkTampil->count())
            {{-- HEADER KATEGORI --}}
            <div class="flex items-center justify-between mb-4 mt-10">
                <h2 class="text-xl font-semibold text-[#5B000B] tracking-tight">
                    {{ $kategori->nama_kategori }}
                </h2>

                @if ($hasMore)
                    <a href="{{ route('produk.by-kategori', $kategori) }}"
                        class="text-sm font-medium
                          text-[#930014]
                          hover:text-[#DB4B3A]
                          transition inline-flex items-center gap-1">
                        Lihat semua →
                    </a>
                @endif
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($produkTampil as $produk)
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="group relative bg-white rounded-2xl
                           border border-black/5
                           hover:border-[#E68757]
                           hover:shadow-lg
                           transition overflow-hidden">
                        <a href="{{ route('produk.show', $produk) }}" class="block p-3">

                            {{-- IMAGE --}}
                            <div class="relative rounded-xl overflow-hidden">
                                <img src="{{ asset(str_replace('produk/', 'produk_assets/', $produk->gambar)) }}"
                                    class="w-full h-40 object-cover
                                       transition-transform duration-300
                                       group-hover:scale-105" />
                            </div>

                            {{-- NAMA --}}
                            <h3 class="mt-3 text-sm font-medium text-black line-clamp-2">
                                {{ $produk->nama_produk }}
                            </h3>

                            {{-- HARGA --}}
                            <div class="mt-1 text-base font-semibold text-[#930014]">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>

                            {{-- STOK (JUMLAH TETAP ADA & DIHIGHLIGHT) --}}
                            <div
                                class="mt-1 text-xs font-semibold flex items-center gap-1
                            {{ $produk->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <span class="uppercase tracking-wide">
                                    Stok:
                                </span>
                                <span class="text-sm">
                                    {{ $produk->stok }}
                                </span>
                            </div>

                            {{-- LOKASI / MART --}}
                            <div class="mt-1 text-xs text-black/60 leading-snug">
                                Lokasi:
                                <div>
                                    @foreach ($produk->highlightedMarts() as $mart)
                                        <span
                                            class="
                                        {{ $mart['is_active'] ? 'text-[#930014] font-semibold' : 'text-black/50' }}">
                                            {{ $mart['nama'] }}
                                        </span>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </a>

                        {{-- ACTION BUTTON --}}
                        <div x-show="hover" x-transition.opacity
                            class="absolute top-3 right-3 flex flex-col gap-2 z-20 pointer-events-auto">
                            {{-- Wishlist --}}
                            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                                <button type="submit"
                                    class="w-9 h-9 rounded-full bg-[#E7BD8A]/80 hover:bg-[#E68757]
                                    border border-[#930014]/30 flex items-center justify-center
                                    text-[#930014] hover:text-white transition">
                                    @include('icons.heart')
                                </button>
                            </form>




                            {{-- Cart --}}
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                {{-- Ubah name menjadi 'produk_id' agar sesuai dengan Controller & Database --}}
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                                <button type="submit"
                                    class="w-9 h-9 rounded-full bg-[#DB4B3A] hover:bg-[#930014]
        border border-[#930014] flex items-center justify-center
        text-white transition">
                                    @include('icons.cart')
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

</div>
