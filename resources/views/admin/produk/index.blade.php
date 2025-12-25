<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Kelola Produk</h2>
    </x-slot>

    <div 
        x-data="{
            search: '',
        }"
        class="py-6 max-w-7xl mx-auto"
    >
        <div class="flex justify-between mb-4">
            <a href="{{ route('admin.produk.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                + Tambah Produk
            </a>

            <input 
                type="text"
                x-model="search"
                placeholder="Cari produk..."
                class="border rounded px-3 py-2 text-sm"
            >
        </div>

        <div class="bg-white rounded shadow p-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left bg-gray-50">
                        <th class="py-2 px-2">Gambar</th>
                        <th class="py-2 px-2">Nama</th>
                        <th class="py-2 px-2">Mart</th>
                        <th class="py-2 px-2">Kategori</th>
                        <th class="py-2 px-2">Harga</th>
                        <th class="py-2 px-2">Stok</th>
                    </tr>
                </thead>
            <tbody>
            @foreach($produk as $p)
                <tr 
                    x-show="'{{ strtolower($p->nama_produk) }}'.includes(search.toLowerCase())"
                    class="border-b hover:bg-indigo-50 transition"
                >
                    {{-- GAMBAR --}}
                    <td class="py-2 px-2">
                        @if($p->gambar)
                            <img 
                                src="{{ asset($p->gambar) }}"
                                class="h-16 w-16 object-cover rounded-lg shadow"
                            >
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>

                    {{-- NAMA --}}
                    <td class="py-2 px-2 font-medium">
                        {{ $p->nama_produk }}
                    </td>

                    {{-- MART --}}
<td>
    @forelse($p->marts as $m)
        <span class="inline-block bg-indigo-100 text-indigo-700 px-2 py-1 text-xs rounded mr-1">
            {{ $m->nama_mart }}
        </span>
    @empty
        <span class="text-gray-400">-</span>
    @endforelse
</td>



                    {{-- KATEGORI --}}
                    <td class="py-2 px-2">
                        {{ $p->kategori->nama_kategori ?? '-' }}
                    </td>

                    {{-- HARGA --}}
                    <td class="py-2 px-2">
                        Rp {{ number_format($p->harga) }}
                    </td>

                    {{-- STOK --}}
                    <td class="py-2 px-2">
                        <span class="{{ $p->stok <= 5 ? 'text-red-500 font-semibold' : 'text-green-600' }}">
                            {{ $p->stok }}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>

            </table>
        </div>
    </div>
</x-app-layout>
