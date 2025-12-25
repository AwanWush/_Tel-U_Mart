<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 pt-6 pb-12 font-sans bg-gray-50 min-h-screen">
        
        {{-- HEADER HASIL PENCARIAN --}}
        <div class="mb-8 border-b border-gray-200 pb-4 flex justify-between items-end">
            <div>
                <p class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1 leading-none default">
                    Menampilkan hasil pencarian produk & kategori
                </p>
                <h1 class="text-2xl font-black text-[#5B000B] tracking-tighter uppercase default leading-none">
                    "{{ request('q') }}"
                </h1>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest leading-none">
                    {{ $produk->count() }} Produk Ditemukan
                </p>
                <a href="{{ route('produk.index') }}" class="text-[11px] text-[#930014] font-semi bold uppercase tracking-tighter hover:underline mt-3 block transition">
                    Reset Filter
                </a>
            </div>
        </div>

        @if($produk->count() > 0)
            {{-- GRID DISAMAKAN DENGAN COMPONENT --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($produk as $p)
                    <div
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="group relative bg-white rounded-2xl
                               border border-black/5
                               hover:border-[#E68757]
                               hover:shadow-lg
                               transition overflow-hidden flex flex-col h-full"
                    >
                        <a href="{{ route('produk.show', $p) }}" class="block p-3 flex-grow">

                            {{-- IMAGE --}}
                            <div class="relative rounded-xl overflow-hidden bg-white">
                                <img
                                    src="{{ asset(str_replace('produk/', 'produk_assets/', $p->gambar)) }}"
                                    class="w-full h-40 object-contain
                                           transition-transform duration-300
                                           group-hover:scale-105"
                                />
                            </div>

                            {{-- NAMA --}}
                            <h3 class="mt-3 text-sm font-medium text-black line-clamp-2 leading-tight min-h-[40px]">
                                {{ $p->nama_produk }}
                            </h3>

                            {{-- HARGA --}}
                            <div class="mt-1 text-base font-semibold text-[#930014]">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </div>

                            {{-- STOK (JUMLAH TETAP ADA & DIHIGHLIGHT) --}}
                            <div class="mt-1 text-xs font-semibold flex items-center gap-1
                                {{ $p->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <span class="uppercase tracking-wide">
                                    Stok:
                                </span>
                                <span class="text-sm">
                                    {{ $p->stok }}
                                </span>
                            </div>

                            {{-- LOKASI / MART --}}
                            <div class="mt-1 text-xs text-black/60 leading-snug">
                                Lokasi:
                                <div class="mt-0.5">
                                    @php
                                        // Pastikan memanggil method highlightedMarts jika tersedia di model Produk
                                        $marts = method_exists($p, 'highlightedMarts') ? $p->highlightedMarts() : [];
                                    @endphp
                                    
                                    @if(count($marts) > 0)
                                        @foreach ($marts as $mart)
                                            <span class="{{ $mart['is_active'] ? 'text-[#930014] font-semibold' : 'text-black/50' }}">
                                                {{ $mart['nama'] }}
                                            </span>@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        {{-- Fallback jika method tidak ada --}}
                                        <span class="text-black/50 italic">📍 {{ $p->marts->pluck('nama_mart')->implode(', ') }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>

                        {{-- ACTION BUTTON (HOVER) --}}
                        <div
                            x-show="hover"
                            x-transition.opacity
                            class="absolute top-3 right-3 flex flex-col gap-2"
                            style="display: none;"
                        >
                            {{-- Wishlist --}}
                            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <button type="submit"
                                    class="w-9 h-9 rounded-full bg-[#E7BD8A]/80 hover:bg-[#E68757]
                                        border border-[#930014]/30 flex items-center justify-center
                                        text-[#930014] hover:text-white transition shadow-sm">
                                    @include('icons.heart')
                                </button>
                            </form>

                            {{-- Cart --}}
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <button type="submit"
                                    class="w-9 h-9 rounded-full bg-[#DB4B3A] hover:bg-[#930014]
                                        border border-[#930014] flex items-center justify-center
                                        text-white transition shadow-sm">
                                    @include('icons.cart')
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- TAMPILAN JIKA TIDAK ADA HASIL --}}
            <div class="py-20 text-center">
                <div class="text-5xl mb-4 text-[#5B000B] opacity-20">🔍</div>
                <h3 class="text-xl font-bold text-gray-800 uppercase tracking-tight">Produk Tidak Ditemukan</h3>
                <p class="text-sm text-gray-400 mt-2">Coba gunakan kata kunci lain seperti "makanan", "sabun", atau "token".</p>
                <a href="{{ route('produk.index') }}" 
                   class="mt-8 inline-block px-10 py-3 bg-[#5B000B] text-white text-xs font-black rounded-xl uppercase tracking-widest active:scale-95 transition-all shadow-lg shadow-red-100">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>

    <style>
        .font-sans { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif !important; }
    </style>
</x-app-layout>