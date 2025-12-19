<x-app-layout>
    {{-- <x-slot name="header"> ... </x-slot> --}}

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-8">

            {{-- Welcome Card --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl shadow-lg p-8 transform transition hover:scale-[1.01] duration-300">
                <h3 class="text-4xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }} 👋</h3>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-indigo-500 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Produk</p>
                    <h4 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">{{ $totalProduk }}</h4>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Pesanan Masuk</p>
                    <h4 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">{{ $pesananMasuk }}</h4>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-red-500 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Produk Habis</p>
                    <h4 class="text-3xl font-extrabold text-red-600 mt-2">{{ $stokHabis }}</h4>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition">
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Omset Bulan Ini</p>
                    <h4 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">Rp {{ number_format($penjualanBulanIni) }}</h4>
                </div>
            </div>

            {{-- ================= QUICK ACTION ADMIN ================= --}}
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mt-8">Menu Cepat</h3>
            
            {{-- Hapus x-data di parent sini, biarkan bersih --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- ITEM 1: KELOLA PRODUK --}}
                <a href="{{ route('admin.produk.index') }}"
                   class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-indigo-200">
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            {{-- Ikon Box --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        {{-- Panah yang muncul saat hover --}}
                        <span class="text-indigo-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-indigo-600 transition-colors">Kelola Produk</h4>
                    <p class="text-gray-500 text-sm mt-1">Tambah, edit & update stok barang</p>
                </a>

                {{-- ITEM 2: KATEGORI --}}
                <a href="{{ route('admin.kategori.index') }}"
                   class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-indigo-200">
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            {{-- Ikon Tag --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="text-blue-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-blue-600 transition-colors">Kategori</h4>
                    <p class="text-gray-500 text-sm mt-1">Atur pengelompokan produk</p>
                </a>

                {{-- ITEM 3: PESANAN --}}
                <a href="{{ route('admin.pesanan.index') }}"
                   class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 
                          transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-indigo-200">
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                            {{-- Ikon Clipboard --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-purple-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                            →
                        </span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-purple-600 transition-colors">Pesanan Masuk</h4>
                    <p class="text-gray-500 text-sm mt-1">Cek pesanan yang perlu diproses</p>
                </a>

                {{-- ITEM 4: LAPORAN --}}
                <a href="{{ route('penjualan.bulanini') }}"
                    class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 
                           transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-indigo-200">
                     
                     <div class="flex items-center justify-between mb-4">
                         <div class="p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                             </svg>
                         </div>
                         <span class="text-green-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                             →
                         </span>
                     </div>
 
                     <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-green-600 transition-colors">Laporan</h4>
                     <p class="text-gray-500 text-sm mt-1">Rekap penjualan bulanan</p>
                 </a>

            </div>

        </div>
    </div>
</x-app-layout>