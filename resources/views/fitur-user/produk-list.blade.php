@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-200">🛍️ Daftar Produk</h1>

    {{-- Tombol Filter Kategori --}}
    <div class="flex justify-center space-x-4 mb-6">
        <a href="{{ route('produk.user') }}"
           class="px-4 py-2 rounded {{ !$kategori ? 'bg-blue-600 text-white' : 'bg-gray-300 text-black' }}">
            Semua Produk
        </a>
        <a href="{{ route('produk.user', ['kategori' => 'galon']) }}"
           class="px-4 py-2 rounded {{ $kategori == 'galon' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-black' }}">
            💧 Galon
        </a>
        <a href="{{ route('produk.user', ['kategori' => 'token']) }}"
           class="px-4 py-2 rounded {{ $kategori == 'token' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-black' }}">
            ⚡ Token Listrik
        </a>
    </div>

    {{-- Grid Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="bg-gray-700 rounded-lg shadow p-4 text-white text-center">
                @if($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" class="w-full h-48 object-cover rounded mb-3" alt="{{ $product->nama_produk }}">
                @else
                    <div class="w-full h-48 bg-gray-500 flex items-center justify-center rounded mb-3">
                        <span class="text-gray-300">Tidak ada gambar</span>
                    </div>
                @endif

                <h3 class="text-lg font-bold">{{ $product->nama_produk }}</h3>
                <p class="text-sm text-gray-300">{{ $product->deskripsi }}</p>
                <p class="mt-2 font-semibold text-yellow-400">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                @if($product->stok > 0)
                    <button class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Tambah ke Keranjang
                    </button>
                @else
                    <button disabled class="mt-3 bg-gray-500 text-white px-4 py-2 rounded opacity-70 cursor-not-allowed">
                        Habis
                    </button>
                @endif
            </div>
        @empty
            <p class="text-center col-span-3 text-gray-300">Tidak ada produk ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection
