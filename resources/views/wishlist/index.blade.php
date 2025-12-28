<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                Wishlist Kamu <span class="text-red-600">❤️</span>
            </h2>
            <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-[10px] font-bold border border-red-100 uppercase">
                {{ $items->count() }} Produk
            </span>
        </div>
    </x-slot>

   
    <div class="pt-0 pb-10 bg-[#f9fafb] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-1">

            @if ($items->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-12 text-center border border-gray-100">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🛒</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Wishlist masih kosong</h3>
                    <p class="text-gray-500 mb-6 text-sm">Simpan produk favoritmu di sini agar mudah ditemukan.</p>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700 transition-all font-bold text-sm">
                        Eksplor Produk
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    
                    @foreach ($items as $item)
                        <div x-data="{ hover: false }" 
                             @mouseenter="hover = true" 
                             @mouseleave="hover = false"
                             class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-3 transition-all duration-300 hover:shadow-md hover:-translate-y-1 relative overflow-hidden">
                            
                            @php
                                $gambar = $item->produk->gambar;
                                $cleanFileName = str_replace(['produk_assets/', 'produk/', 'public/'], '', $gambar);
                                $imagePath = $gambar 
                                    ? asset('produk_assets/' . $cleanFileName)
                                    : asset('images/no-image.png');
                            @endphp

                            <div class="relative aspect-square bg-gray-50 rounded-xl overflow-hidden mb-3 border border-gray-50">
                                <img src="{{ $imagePath }}" 
                                     alt="{{ $item->produk->nama_produk }}"
                                     class="w-full h-full object-contain p-3 transition-transform duration-500 group-hover:scale-105"
                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </div>

                            <div class="space-y-1">
                                <h3 class="font-bold text-gray-800 text-[11px] line-clamp-2 h-8 leading-tight group-hover:text-red-600 transition-colors">
                                    {{ $item->produk->nama_produk ?? $item->produk->nama }}
                                </h3>
                                
                                <p class="text-red-600 font-black text-sm">
                                    Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </p> 
                            </div>

                            <div class="mt-3 pt-2 border-t border-gray-50 flex flex-col gap-1.5">
                                <a href="{{ route('produk.show', $item->produk->id) }}" 
                                   class="text-center w-full py-1.5 text-[10px] font-bold bg-gray-50 text-gray-700 rounded-lg uppercase tracking-tight">
                                    Detail
                                </a>

                                <form method="POST" action="{{ route('wishlist.destroy', $item->id) }}" 
                                      @submit.prevent="if(confirm('Hapus item ini?')) $el.submit()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full py-1.5 text-gray-400 text-[9px] font-bold rounded-lg hover:text-red-600 hover:bg-red-50 transition-all flex items-center justify-center gap-1 uppercase">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>