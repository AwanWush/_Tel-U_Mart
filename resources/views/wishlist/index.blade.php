<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wishlist Kamu ❤️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($items->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center">
                    <p class="text-gray-600 mb-6 text-lg">
                        Yah, wishlist masih kosong 😥
                    </p>

                    <a href="{{ route('dashboard') }}"
                        class="inline-block bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition font-semibold">
                        Ke Beranda
                    </a>
                </div>
            @else
                {{-- Grid disesuaikan agar pas dengan max-w-7xl --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach ($items as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition">
                            @php
                                $gambar = $item->produk->gambar;
                                
                                // Membersihkan path agar selalu mengarah ke public/produk_assets
                                $cleanFileName = str_replace(['produk_assets/', 'produk/', 'public/'], '', $gambar);
                                $imagePath = $gambar 
                                    ? asset('produk_assets/' . $cleanFileName)
                                    : asset('images/no-image.png');
                            @endphp

                            {{-- Wadah Gambar --}}
                            <div class="relative w-full h-44 bg-gray-50 rounded-xl overflow-hidden mb-4">
                                <img src="{{ $imagePath }}" 
                                     alt="{{ $item->produk->nama_produk }}"
                                     class="w-full h-full object-contain p-2"
                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </div>

                            {{-- Informasi Produk --}}
                            <div class="space-y-1">
                                <h3 class="font-bold text-gray-800 text-sm line-clamp-2 h-10">
                                    {{ $item->produk->nama_produk ?? $item->produk->nama }}
                                </h3>
                                
                                <p class="text-red-600 font-extrabold text-base">
                                    Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mt-4 flex flex-col gap-2">
                                {{-- Tombol Lihat Detail --}}
                                <a href="{{ route('produk.show', $item->produk->id) }}" 
                                   class="text-center w-full py-1.5 text-xs font-semibold bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                    Lihat Produk
                                </a>

                                {{-- Form Hapus --}}
                                <form method="POST" action="{{ route('wishlist.destroy', $item->id) }}" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Hapus dari wishlist?')"
                                        class="w-full py-1.5 text-red-600 text-xs font-bold border border-red-100 rounded-lg hover:bg-red-50 transition">
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