@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-semibold mb-6">Lihat Produk</h2>

    <!-- Tabel produk -->
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk as $p)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $p->nama }}</td>
                    <td class="px-4 py-2">{{ $p->kategori->nama }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($p->harga,0,',','.') }}</td>
                    <td class="px-4 py-2">{{ $p->stok }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
