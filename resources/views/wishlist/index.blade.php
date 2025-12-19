<x-layout>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
                Wishlist Kamu ❤️
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if($items->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <p class="text-black-600 dark:text-nlack-300 mb-4">
                            Yah wishlist masih kosong 😥
                        </p>

                        <a href="{{ route('dashboard') }}"
                           class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Ke Beranda
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($items as $item)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                @php
                                 $gambar = $item->produk->gambar;

                                  $imagePath = $gambar
                                ? asset(
                                    str_starts_with($gambar, 'produk/')
                                        ? $gambar
                                        : (str_starts_with($gambar, 'public/produk/')
                                            ? str_replace('public/', '', $gambar)
                                            : 'produk/'.$gambar)
                                )
                                : asset('images/no-image.png');
                        @endphp

                        <img
                            src="{{ $imagePath }}"
                            alt="{{ $item->produk->nama }}"
                            class="w-full h-40 object-contain rounded mb-3">

                                <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $item->produk->nama }}
                                </h3>
                                <p class="text-indigo-600 font-bold">
                                    Rp {{ number_format($item->produk->harga) }}
                                </p>
                                <div class="mt-3 flex justify-between items-center">
                                    <form method="POST" action="{{ route('wishlist.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                        class="px-4 py-1 text-red-600 text-sm border border-red-300 rounded-full hover:bg-red-50 transition">
                                         Hapus
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->produk->id }}">
                                        <button
                                        class="px-4 py-1 text-indigo-600 text-sm border border-indigo-300 rounded-full hover:bg-indigo-50 transition">
                                        Ke Cart
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
</x-layout>
