<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-tight">
            {{ __('Katalog Produk') }}
        </h2>
    </x-slot>

    <div class="pt-2 pb-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div x-data="{ openFilter: false, showAll: false }" x-cloak>
            {{-- DROPDOWN FILTER KATEGORI --}}
            <div class="mb-4 mt-4 flex flex-col md:flex-row md:items-center justify-between gap-4 px-4 sm:px-0">
                <div class="relative inline-block text-left">
                    <button @click="openFilter = !openFilter" type="button" 
                            class="inline-flex justify-center items-center rounded-xl border border-gray-200 shadow-sm px-4 py-1.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all active:scale-95">
                        <span class="mr-2 text-xs">📂</span>
                        {{ empty($kategoriId) ? 'Pilih Kategori' : ($kategori->find($kategoriId)->nama_kategori ?? 'Kategori') }}
                        <svg class="ml-2 h-4 w-4 transition-transform duration-300" :class="openFilter ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="openFilter" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         @click.outside="openFilter = false" 
                         class="origin-top-left absolute left-0 mt-1 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border border-gray-100">
                        <div class="py-1">
                            <a href="{{ route('produk.index') }}" class="block px-4 py-2 text-sm hover:bg-red-50 {{ empty($kategoriId) ? 'text-[#5B000B] font-bold bg-red-50' : 'text-gray-700' }}">Semua Produk</a>
                            @foreach ($kategori as $k)
                                <a href="{{ route('produk.index', ['kategori' => $k->id]) }}" class="block px-4 py-2 text-sm hover:bg-red-50 {{ $kategoriId == $k->id ? 'text-[#5B000B] font-bold bg-red-50' : 'text-gray-700' }}">
                                    {{ $k->nama_kategori }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 pt-4 pb-8">
                @if (!empty($kategoriId))
                    {{-- GRID SAAT FILTER AKTIF --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @forelse ($produk as $p)
                            <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                                 class="group relative bg-white rounded-2xl border border-black/5 hover:border-[#E68757] hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                                <a href="{{ route('produk.show', $p) }}" class="block p-3 flex-grow text-left">
                                    <div class="relative rounded-xl overflow-hidden bg-white">
                                        <img src="{{ asset('produk_assets/' . basename($p->gambar)) }}" class="w-full h-40 object-contain transition-transform duration-500 group-hover:scale-110" />
                                    </div>
                                    <h3 class="mt-3 text-[13px] font-semibold text-gray-900 line-clamp-2 leading-tight min-h-[34px] tracking-tight">{{ $p->nama_produk }}</h3>
                                    <div class="mt-1 text-base font-bold text-[#930014]">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                                    <div class="mt-1 text-[11px] font-bold text-[#009661] uppercase tracking-wide">STOK: {{ $p->stok }}</div>
                                    {{-- LOKASI / MART --}}
                                    <div class="mt-1 text-xs text-black/60 leading-snug">
                                        Lokasi:
                                        <div>
                                            @foreach ($p->highlightedMarts() as $mart)
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
                                <div x-show="hover" x-cloak x-transition.opacity class="absolute top-3 right-3 flex flex-col gap-2 z-10">
                                    <button class="w-9 h-9 rounded-full bg-[#E7BD8A]/80 hover:bg-[#E68757] border border-[#930014]/30 flex items-center justify-center text-[#930014] hover:text-white transition-all transform active:scale-75 duration-200 shadow-sm">
                                        @include('icons.heart')
                                    </button>
                                    <button class="w-9 h-9 rounded-full bg-[#DB4B3A] hover:bg-[#930014] flex items-center justify-center text-white transition-all transform active:scale-75 duration-200 shadow-sm">
                                        @include('icons.cart')
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-400 py-10 text-sm italic">Produk tidak tersedia.</p>
                        @endforelse
                    </div>
                @else
                    {{-- CAROUSEL KATEGORI (DIBATASI 2 PERTAMA) --}}
                    @foreach ($kategori as $index => $k)
                        @if ($k->produk->count() > 0)
                            <div class="mb-10" x-show="showAll || {{ $index }} < 2" x-cloak x-transition:enter="transition ease-out duration-300 opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="flex items-center justify-between mb-4 px-4 sm:px-0">
                                    <h2 class="text-xl font-bold text-[#5B000B] tracking-tight uppercase italic border-l-4 border-[#5B000B] pl-3">{{ $k->nama_kategori }}</h2>
                                    <a href="{{ route('produk.index', ['kategori' => $k->id]) }}" class="text-xs font-bold text-[#930014] hover:underline uppercase tracking-widest">Lihat Semua →</a>
                                </div>

                                <div class="relative">
                                    <div class="flex overflow-x-auto gap-4 pb-6 px-4 sm:px-0 scrollbar-hide snap-x snap-mandatory">
                                        @foreach ($k->produk as $p)
                                            <div class="min-w-[170px] sm:min-w-[200px] md:min-w-[220px] snap-start">
                                                <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false" 
                                                     class="group relative bg-white rounded-2xl border border-black/5 hover:border-[#E68757] hover:shadow-xl transition-all duration-300 flex flex-col h-full">
                                                    <a href="{{ route('produk.show', $p) }}" class="block p-3 flex-grow text-left">
                                                        <div class="relative rounded-xl overflow-hidden bg-white">
                                                            <img src="{{ asset('produk_assets/' . basename($p->gambar)) }}" class="w-full h-40 object-contain transition-transform duration-500 group-hover:scale-110" />
                                                        </div>
                                                        <h3 class="mt-3 text-[13px] font-semibold text-gray-900 line-clamp-2 min-h-[34px] tracking-tight">{{ $p->nama_produk }}</h3>
                                                        <div class="mt-1 text-base font-bold text-[#930014]">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                                                        <div class="mt-1 text-[11px] font-bold text-[#009661] uppercase tracking-wide">STOK: {{ $p->stok }}</div>
                                                        {{-- LOKASI / MART --}}
                                                        <div class="mt-1 text-xs text-black/60 leading-snug">
                                                            Lokasi:
                                                            <div>
                                                                @foreach ($p->highlightedMarts() as $mart)
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
                                                    <div x-show="hover" x-cloak x-transition.opacity class="absolute top-3 right-3 flex flex-col gap-2 z-10">
                                                        <button class="w-9 h-9 rounded-full bg-[#E7BD8A]/80 hover:bg-[#E68757] border border-[#930014]/30 flex items-center justify-center text-[#930014] hover:text-white transition-all transform active:scale-75 duration-200 shadow-sm">
                                                            @include('icons.heart')
                                                        </button>
                                                        <button class="w-9 h-9 rounded-full bg-[#DB4B3A] hover:bg-[#930014] flex items-center justify-center text-white transition-all transform active:scale-75 duration-200 shadow-sm">
                                                            @include('icons.cart')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{-- TOMBOL LIHAT SEMUA KATEGORI --}}
                    @if($kategori->count() > 2)
                        <div class="mt-4 mb-10 text-center" x-show="!showAll">
                            <button @click="showAll = true" 
                                    class="inline-block px-10 py-3 bg-[#5B000B] text-white text-[10px] font-black rounded-2xl shadow-lg uppercase tracking-widest active:scale-95 transition-all hover:bg-black">
                                    LIHAT SEMUA KATEGORI &darr;
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <style>
        .font-sans { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .snap-x { scroll-snap-type: x mandatory; }
        .snap-start { scroll-snap-align: start; }
    </style>
</x-app-layout>