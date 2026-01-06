<x-app-layout>
    <div class="pt-[100px]"> {{-- Padding luar yang lebih kecil --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 mb-4 text-sm font-bold text-gray-500">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#dc2626] transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                    </svg>
                    <span class="tracking-wide">Dashboard</span>
                </a>
            </nav>
            <div class="flex items-center gap-0 mb-6">
                <span class="text-2xl"></span>
                <h2 class="text-xl font-bold text-red-700 uppercase tracking-widest">
                    Kelola Produk
                </h2>
            </div>
        </div>
    </div>

    <div x-data="{ search: '' }" class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">

        {{-- Action Bar: Tombol Tambah & Search --}}
        <div class="flex flex-col md:flex-row md:justify-between items-center gap-4 mb-6">
            <a href="{{ route('admin.produk.create') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg font-bold transition shadow flex items-center">
                <span class="mr-2 text-lg">+</span> Tambah Produk
            </a>

            <div class="w-full md:w-80">
                <input type="text" x-model="search" placeholder="Cari produk..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-red-500 focus:border-red-500 shadow-sm">
            </div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-red-600 text-white uppercase text-[11px] font-bold tracking-wider">
                        <th class="py-4 px-4 text-left">Gambar</th>
                        <th class="py-4 px-4 text-left">Nama</th>
                        <th class="py-4 px-4 text-left">Mart</th>
                        <th class="py-4 px-4 text-left">Kategori</th>
                        <th class="py-4 px-4 text-left">Harga</th>
                        <th class="py-4 px-4 text-center">Stok</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($produk as $p)
                        <tr x-show="'{{ strtolower($p->nama_produk) }}'.includes(search.toLowerCase())"
                            class="hover:bg-red-50/50 transition">
                            {{-- Kolom Gambar --}}
                            <td class="py-4 px-4">
                                <div
                                    class="h-16 w-16 bg-white border border-gray-200 rounded-lg flex items-center justify-center overflow-hidden shadow-sm">
                                    @if ($p->gambar)
                                        <img src="{{ asset(str_replace('produk/', 'produk_assets/', $p->gambar)) }}"
                                            alt="{{ $p->nama_produk }}" class="h-full w-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    @endif
                                </div>
                            </td>

                            {{-- Kolom Nama --}}
                            <td class="py-4 px-4 font-semibold text-gray-800">
                                {{ $p->nama_produk }}
                            </td>

                            {{-- Kolom Mart (Label Pink) --}}
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($p->marts as $m)
                                        <span
                                            class="inline-block bg-[#FFF0F0] text-red-600 px-2 py-1 text-[10px] font-bold rounded uppercase border border-red-100">
                                            {{ $m->nama_mart }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400">-</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Kolom Kategori --}}
                            <td class="py-4 px-4 text-gray-600">
                                {{ $p->kategori->nama_kategori ?? '-' }}
                            </td>

                            {{-- Kolom Harga --}}
                            <td class="py-4 px-4 font-medium text-gray-900">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </td>

                            {{-- Kolom Stok (Warna sesuai kondisi) --}}
                            <td class="py-4 px-4 text-center">
                                <span
                                    class="font-bold text-base {{ $p->stok <= 5 ? 'text-red-600' : 'text-green-600' }}">
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
