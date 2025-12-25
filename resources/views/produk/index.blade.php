<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-tight">
            {{ __('Katalog Produk') }}
        </h2>
    </x-slot>

    {{-- pt-2 agar mepet ke header, pb-8 untuk jarak bawah --}}
    <div class="pt-2 pb-8 bg-gray-50 min-h-screen font-sans" x-data="{ openFilter: false, showAll: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- DROPDOWN FILTER KATEGORI --}}
            <div class="mb-4 flex flex-col md:flex-row md:items-center justify-between gap-4 px-4 sm:px-0">
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

            @if (!empty($kategoriId))
                {{-- GRID SAAT FILTER AKTIF --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 px-4 sm:px-0">
                    @forelse ($produk as $p)
                        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                            <a href="{{ route('produk.show', $p) }}" class="block p-3 aspect-square overflow-hidden bg-white">
                                <img src="{{ asset('produk_assets/' . basename($p->gambar)) }}" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-500">
                            </a>
                            <div class="px-3 pb-3 flex flex-col flex-grow">
                                <h4 class="text-[11px] font-semibold text-gray-800 line-clamp-2 mb-0.5 leading-tight tracking-tight min-h-[28px]">{{ $p->nama_produk }}</h4>
                                <p class="text-[#5B000B] font-bold text-[14px] mb-0.5">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                <div class="mt-auto">
                                    <p class="text-[10px] font-medium text-green-500 flex items-center leading-none">
                                        <span class="w-1 h-1 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                                        Stok: {{ $p->stok }}
                                    </p>
                                    <p class="text-[9px] text-gray-400 font-medium truncate mt-0.5 italic leading-none">{{ $p->marts->pluck('nama_mart')->implode(', ') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-400 py-10 text-sm">Produk tidak tersedia.</p>
                    @endforelse
                </div>
            @else
                {{-- TAMPILAN HALAMAN UTAMA --}}
                @foreach ($kategori as $index => $k)
                    @if ($k->produk->count() > 0)
                        <div class="mb-5" x-show="showAll || {{ $index }} < 2" x-transition:enter="transition ease-out duration-300">
                            <div class="flex justify-between items-center mb-1 px-4 sm:px-0">
                                <h3 class="text-sm font-bold text-gray-800 tracking-tight uppercase">{{ $k->nama_kategori }}</h3>
                                <a href="{{ route('produk.index', ['kategori' => $k->id]) }}" 
                                   class="group flex items-center text-[10px] font-bold text-blue-600 hover:text-[#5B000B] transition-all uppercase tracking-wider">
                                    Lihat Semua 
                                    <svg class="ml-1 w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>

                            <div class="flex overflow-x-auto pb-2 scrollbar-hide snap-x snap-mandatory gap-3 px-4 sm:px-0 -mx-4 sm:mx-0">
                                @foreach ($k->produk as $p)
                                    <div class="min-w-[155px] sm:min-w-[180px] md:min-w-[200px] snap-start h-full flex flex-col">
                                        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                                            <a href="{{ route('produk.show', $p) }}" class="block p-3 aspect-square overflow-hidden bg-white">
                                                <img src="{{ asset('produk_assets/' . basename($p->gambar)) }}" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-500">
                                            </a>
                                            <div class="px-3 pb-3 flex flex-col flex-grow">
                                                {{-- min-h-[28px] menjaga agar nama produk tidak membuat tinggi kartu berbeda --}}
                                                <h4 class="text-[11px] font-semibold text-gray-800 line-clamp-2 mb-0.5 leading-tight tracking-tight min-h-[28px]">{{ $p->nama_produk }}</h4>
                                                
                                                <p class="text-[#5B000B] font-bold text-[14px] mb-0.5">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                                
                                                <div class="mt-auto">
                                                    <p class="text-[10px] font-medium text-green-500 flex items-center leading-none">
                                                        <span class="w-1 h-1 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                                                        Stok: {{ $p->stok }}
                                                    </p>
                                                    <p class="text-[9px] text-gray-400 font-medium truncate mt-0.5 leading-none italic">{{ $p->marts->pluck('nama_mart')->implode(', ') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="mt-1 mb-6 text-center" x-show="!showAll">
                    <button @click="showAll = true" 
                           class="inline-block px-8 py-2 bg-white border border-gray-200 text-[#5B000B] text-[10px] font-bold rounded-xl shadow-sm hover:bg-red-50 transition-all active:scale-95 uppercase tracking-widest">
                           LIHAT SEMUA KATEGORI &darr;
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .font-sans { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif !important; }
    </style>
</x-app-layout> 