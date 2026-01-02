<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 space-y-10">

            <div class="mt-4 bg-gradient-to-r from-red-600 to-red-800 text-white rounded-2xl shadow-lg p-8 transition hover:scale-[1.01] duration-300">
                <h3 class="text-4xl font-extrabold tracking-tight">
                    Halo, {{ Auth::user()->name }} 👋
                </h3>
                <p class="mt-2 text-red-100">
                    Selamat datang di Dashboard Admin TJ&T Mart
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-600 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                        Total Produk
                    </p>
                    <h4 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $totalProduk }}
                    </h4>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-600 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                        Pesanan Masuk
                    </p>
                    <h4 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ $pesananMasuk }}
                    </h4>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-600 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                        Produk Habis
                    </p>
                    <h4 class="text-3xl font-extrabold text-red-600 mt-2">
                        {{ $stokHabis }}
                    </h4>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-600 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                        Omset Bulan Ini
                    </p>
                    <h4 class="text-2xl font-extrabold text-gray-800 mt-2">
                        Rp {{ number_format($penjualanBulanIni) }}
                    </h4>
                </div>
            </div>

            <h3 class="text-xl font-bold text-red-700 uppercase tracking-widest">
                Menu Cepat
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('admin.produk.index') }}"
                   class="group bg-white rounded-xl shadow-sm p-6 border border-gray-100
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-red-200">

                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg
                                    group-hover:bg-red-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="text-red-500 opacity-0 -translate-x-2
                                     group-hover:opacity-100 group-hover:translate-x-0 transition">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-red-600 transition">
                        Kelola Produk
                    </h4>
                    <p class="text-gray-500 text-sm mt-1">
                        Tambah, edit & update stok barang
                    </p>
                </a>

                <a href="{{ route('admin.kategori.index') }}"
                   class="group bg-white rounded-xl shadow-sm p-6 border border-gray-100
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-red-200">

                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg
                                    group-hover:bg-red-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="text-red-500 opacity-0 -translate-x-2
                                     group-hover:opacity-100 group-hover:translate-x-0 transition">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-red-600 transition">
                        Kategori
                    </h4>
                    <p class="text-gray-500 text-sm mt-1">
                        Atur pengelompokan produk
                    </p>
                </a>

                <a href="{{ route('admin.pesanan.index') }}"
                   class="group bg-white rounded-xl shadow-sm p-6 border border-gray-100
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-red-200">

                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg
                                    group-hover:bg-red-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                        </div>
                        <span class="text-red-500 opacity-0 -translate-x-2
                                     group-hover:opacity-100 group-hover:translate-x-0 transition">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-red-600 transition">
                        Pesanan Masuk
                    </h4>
                    <p class="text-gray-500 text-sm mt-1">
                        Cek pesanan yang perlu diproses
                    </p>
                </a>

                <a href="{{ route('penjualan.bulanini') }}"
                   class="group bg-white rounded-xl shadow-sm p-6 border border-gray-100
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-red-200">

                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg
                                    group-hover:bg-red-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-red-500 opacity-0 -translate-x-2
                                     group-hover:opacity-100 group-hover:translate-x-0 transition">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-red-600 transition">
                        Laporan
                    </h4>
                    <p class="text-gray-500 text-sm mt-1">
                        Rekap penjualan bulanan
                    </p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
