<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-2xl font-bold text-red-700 leading-tight uppercase tracking-widest">
                📦 Kelola Produk
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50"
         x-data="{ search: '', kategori: '', mart: '' }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-xl shadow-sm p-6 border border-red-100">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

                    <div class="md:col-span-6 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            x-model="search"
                            class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm"
                            placeholder="Cari nama produk..."
                        >
                    </div>

                    <div class="md:col-span-3">
                        <select
                            x-model="kategori"
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm cursor-pointer">
                            <option value="">📂 Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <select
                            x-model="mart"
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm cursor-pointer">
                            <option value="">🏪 Semua Mart</option>
                            @foreach($mart as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mart }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-red-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs uppercase bg-red-600 text-white">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Ketersediaan Mart</th>
                                <th class="px-6 py-4">Harga & Stok</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($produk as $p)
                                <tr
                                    class="hover:bg-red-50 transition"
                                    x-show="(
                                        ('{{ strtolower($p->nama_produk) }}'.includes(search.toLowerCase())) &&
                                        (kategori === '' || kategori == '{{ $p->kategori_id }}') &&
                                        (mart === '' || {{ json_encode($p->marts->pluck('id')->toArray()) }}.includes(parseInt(mart)))
                                    )"
                                >
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-14 w-14">
                                                @if($p->gambar)
                                                    <img class="h-14 w-14 rounded-lg object-cover border shadow-sm" src="{{ asset('storage/' . $p->gambar) }}">
                                                @else
                                                    <div class="h-14 w-14 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-gray-900">{{ $p->nama_produk }}</div>
                                                <div class="text-xs text-gray-400 mt-1 truncate w-40">{{ $p->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            {{ $p->kategori->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($p->marts as $m)
                                                <span class="px-2.5 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                                    {{ $m->nama_mart }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400 italic">Belum tersedia</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                                        <div class="text-xs mt-1 {{ $p->stok <= 5 ? 'text-red-600 font-bold animate-pulse' : 'text-green-600' }}">
                                            Stok: {{ $p->stok }} pcs
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('admin.produk.edit', $p->id) }}"
                                               class="text-red-600 bg-red-50 p-2 rounded hover:bg-red-100 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-white bg-red-600 p-2 rounded hover:bg-red-700 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($produk->isEmpty())
                        <div class="text-center py-10">
                            <h3 class="text-sm font-bold text-gray-700">Belum ada produk</h3>
                            <p class="text-sm text-gray-500">Silakan tambahkan produk baru</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
