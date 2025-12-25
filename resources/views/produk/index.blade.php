<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Produk') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="{ openFilter: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- HEADER SECTION: Filter Dropdown & Info --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="relative inline-block text-left">
                    {{-- Dropdown Filter Kategori --}}
                    <div>
                        <button @click="openFilter = !openFilter" type="button" 
                                class="inline-flex justify-center w-full rounded-xl border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all" 
                                id="menu-button">
                            <span class="mr-2">📂</span>
                            {{ empty($kategoriId) ? 'Semua Kategori' : ($kategori->find($kategoriId)->nama_kategori ?? 'Kategori') }}
                            <svg class="-mr-1 ml-2 h-5 w-5 transition-transform" :class="openFilter ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    {{-- Dropdown Menu --}}
                    <div x-show="openFilter" 
                         @click.outside="openFilter = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="origin-top-left absolute left-0 mt-2 w-64 rounded-2xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('produk.index') }}" class="block px-4 py-3 text-sm hover:bg-red-50 {{ empty($kategoriId) ? 'text-[#d50d27] font-bold bg-red-50' : 'text-gray-700' }}">Semua Produk</a>
                            @foreach ($kategori as $k)
                                <a href="{{ route('produk.index', ['kategori' => $k->id]) }}" 
                                   class="block px-4 py-3 text-sm hover:bg-red-50 {{ $kategoriId == $k->id ? 'text-[#d50d27] font-bold bg-red-50' : 'text-gray-700' }}">
                                    {{ $k->nama_kategori }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if(empty($kategoriId))
                    <div class="flex items-center text-sm text-gray-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        Geser ke samping untuk melihat lainnya
                    </div>
                @endif
            </div>

            {{-- JIKA SEDANG FILTER KATEGORI --}}
            @if (!empty($kategoriId))
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @forelse ($produk as $p)
                         <x-product-grid :product="$p" />
                    @empty
                        <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 font-medium">Produk untuk kategori ini belum tersedia.</p>
                        </div>
                    @endforelse
                </div>

            {{-- JIKA HALAMAN UTAMA (HORIZONTAL SCROLL) --}}
            @else
                @foreach ($kategori as $k)
                    @if ($k->produk->count() > 0)
                        <div class="mb-14">
                            <div class="flex justify-between items-end mb-5">
                                <div class="relative">
                                    <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">
                                        {{ $k->nama_kategori }}
                                    </h3>
                                    <div class="absolute -bottom-1 left-0 h-1.5 w-10 bg-[#d50d27] rounded-full"></div>
                                </div>
                                <a href="{{ route('produk.index', ['kategori' => $k->id]) }}" 
                                   class="group flex items-center text-xs font-black uppercase text-[#d50d27] tracking-widest hover:opacity-70 transition-opacity">
                                    Lihat Semua 
                                    <svg class="ml-1 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>

                            {{-- Scrollable Container --}}
                            <div class="flex overflow-x-auto pb-6 -mx-2 px-2 gap-5 scrollbar-hide snap-x snap-mandatory">
                                @foreach ($k->produk as $p)
                                    <div class="min-w-[190px] sm:min-w-[220px] md:min-w-[240px] snap-start">
                                        {{-- Produk Card --}}
                                        <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 group">
                                            <a href="{{ route('produk.show', $p->id) }}" class="block relative aspect-[4/5] overflow-hidden bg-gray-100">
                                                <img src="{{ asset('produk_assets/' . basename($p->gambar)) }}"
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                                     alt="{{ $p->nama_produk }}">
                                                {{-- Badge Stok --}}
                                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $p->stok > 0 ? 'text-gray-800' : 'text-red-600' }}">
                                                    {{ $p->stok > 0 ? 'Stok: '.$p->stok : 'Habis' }}
                                                </div>
                                            </a>
                                            <div class="p-5">
                                                <div class="flex items-center text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">
                                                    <span class="truncate">📍 {{ $p->marts ? $p->marts->pluck('nama_mart')->first() : 'Umum' }}</span>
                                                </div>
                                                <h4 class="text-sm font-extrabold text-gray-900 line-clamp-1 mb-2">
                                                    {{ $p->nama_produk }}
                                                </h4>
                                                <p class="text-[#d50d27] font-black text-lg tracking-tighter">
                                                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                                                </p>
                                                <a href="{{ route('produk.show', $p->id) }}"
                                                   class="block mt-4 text-center text-[10px] tracking-[0.2em] font-black uppercase bg-[#d50d27] text-white rounded-2xl py-3.5 shadow-lg shadow-red-100 hover:brightness-110 transition-all">
                                                   Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>