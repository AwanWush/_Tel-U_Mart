<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-red-700 uppercase tracking-widest">
            Kelola Produk
        </h2>
    </x-slot>

    <div x-data="{ search: '' }" class="py-8 max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">
            <a href="{{ route('admin.produk.create') }}"
               class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow">
                + Tambah Produk
            </a>

            <input
                type="text"
                x-model="search"
                placeholder="Cari produk..."
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-red-500 focus:border-red-500"
            >
        </div>

        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-red-600 text-white uppercase text-xs tracking-wider">
                        <th class="py-3 px-3 text-left">Gambar</th>
                        <th class="py-3 px-3 text-left">Nama</th>
                        <th class="py-3 px-3 text-left">Mart</th>
                        <th class="py-3 px-3 text-left">Kategori</th>
                        <th class="py-3 px-3 text-left">Harga</th>
                        <th class="py-3 px-3 text-left">Stok</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($produk as $p)
                        <tr
                            x-show="'{{ strtolower($p->nama_produk) }}'.includes(search.toLowerCase())"
                            class="hover:bg-red-50 transition"
                        >
                            <td class="py-3 px-3">
                                @if ($p->gambar)
                                    <img src="{{ asset($p->gambar) }}" class="h-16 w-16 object-cover rounded-lg shadow">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="py-3 px-3 font-semibold text-gray-800">
                                {{ $p->nama_produk }}
                            </td>

                            <td class="py-3 px-3">
                                @forelse($p->marts as $m)
                                    <span class="inline-block bg-red-100 text-red-700 px-2 py-1 text-xs rounded mr-1 mb-1">
                                        {{ $m->nama_mart }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">-</span>
                                @endforelse
                            </td>

                            <td class="py-3 px-3 text-gray-700">
                                {{ $p->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td class="py-3 px-3 font-medium text-gray-800">
                                Rp {{ number_format($p->harga) }}
                            </td>

                            <td class="py-3 px-3 font-semibold {{ $p->stok <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $p->stok }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</x-app-layout>
