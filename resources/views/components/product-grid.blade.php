<div class="max-w-7xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Produk Terbaru</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($produk as $produk)
            <a href="/produk/{{ $produk->id }}" 
               class="group relative block bg-white p-3 rounded-xl shadow hover:shadow-lg transition-shadow duration-300">
                
                {{-- Tombol wishlist & cart --}}
                <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    {{-- Wishlist --}}
                    <button class="bg-white p-1 rounded-full shadow hover:bg-red-100">
                        @include('icons.heart')
                    </button>
                    {{-- Add to cart --}}
                    <button class="bg-white p-1 rounded-full shadow hover:bg-blue-100">
                        @include('icons.cart')
                    </button>
                </div>

                {{-- Gambar --}}
                <img src="{{ asset($produk->gambar) }}" 
                     class="w-full h-40 object-cover rounded-lg" />

                {{-- Nama produk --}}
                <h3 class="mt-2 text-md font-semibold">{{ $produk->nama_produk }}</h3>

                {{-- Diskon --}}
                @if($produk->persentase_diskon)
                    <div class="text-red-500 font-bold">
                        Diskon {{ $produk->persentase_diskon }}%
                    </div>
                @endif

                {{-- Harga --}}
                <div class="text-lg font-bold text-blue-600">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </div>

                {{-- Stok --}}
                <div class="mt-1">
                    <span class="text-sm {{ $produk->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                        Stok: {{ $produk->stok }}
                    </span>
                </div>

                {{-- Lokasi mart --}}
                <div class="text-xs text-gray-500">
                    Lokasi: {{ $produk->marts->pluck('nama_mart')->join(', ') }}
                </div>

            </a>
        @endforeach
    </div>
</div>
