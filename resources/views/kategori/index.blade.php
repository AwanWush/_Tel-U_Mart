<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                📦 Kelola Produk
            </h2>
        </div>
    </x-slot>

    <div class="py-8" 
         x-data="{ 
            search: '', 
            kategori: '', 
            mart: '',
            countResults() {
                // Fungsi opsional untuk menghitung baris yang tampil (logika lanjutan)
                return document.querySelectorAll('tbody tr[x-show=\'true\']').length;
            }
         }">
         
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    
                    <div class="md:col-span-6 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            x-model="search"
                            class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 transition duration-200 sm:text-sm" 
                            placeholder="Cari nama produk..."
                        >
                    </div>

                    <div class="md:col-span-3">
                        <select 
                            x-model="kategori" 
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm cursor-pointer"
                        >
                            <option value="">📂 Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <select 
                            x-model="mart" 
                            class="block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm cursor-pointer"
                        >
                            <option value="">🏪 Semua Mart</option>
                            @foreach($mart as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mart }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-4 font-bold tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-bold tracking-wider">Ketersediaan Mart</th>
                                <th scope="col" class="px-6 py-4 font-bold tracking-wider">Harga & Stok</th>
                                <th scope="col" class="px-6 py-4 font-bold tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($produk as $p)
                                <tr 
                                    class="bg-white hover:bg-indigo-50 transition duration-150 ease-in-out"
                                    x-show="(
                                        ('{{ strtolower($p->nama_produk) }}'.includes(search.toLowerCase())) &&
                                        (kategori === '' || kategori == '{{ $p->kategori_id }}') &&
                                        (mart === '' || {{ json_encode($p->marts->pluck('id')->toArray()) }}.includes(parseInt(mart)))
                                    )"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-14 w-14">
                                                @if($p->gambar)
                                                    <img class="h-14 w-14 rounded-lg object-cover border border-gray-200 shadow-sm" src="{{ asset('storage/' . $p->gambar) }}" alt="">
                                                @else
                                                    <div class="h-14 w-14 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $p->nama_produk }}</div>
                                                <div class="text-xs text-gray-400 mt-1 truncate w-40">{{ $p->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $p->kategori->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($p->marts as $m)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                                    {{ $m->nama_mart }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400 italic">Belum tersedia di Mart</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                                        <div class="text-xs mt-1 {{ $p->stok <= 5 ? 'text-red-600 font-bold animate-pulse' : 'text-green-600' }}">
                                            Stok: {{ $p->stok }} pcs
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('produk.edit', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded hover:bg-indigo-100 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded hover:bg-red-100 transition">
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
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk baru.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>