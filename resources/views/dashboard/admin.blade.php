<x-app-layout>
    <style>
        .bg-dark-maroon { background-color: #5B000B; }
        .text-dark-maroon { color: #5B000B; }
        /* Efek kartu statistik agar lebih modern */
        .stat-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-card:hover { transform: translateY(-5px); }
        /* Animasi panah pada menu cepat */
        .group:hover .arrow-icon { transform: translateX(5px); opacity: 1; }
    </style>

    <div class="pt-[100px] py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 space-y-10">

            {{-- WELCOME BANNER --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-[#5B000B] via-[#dc2626] to-[#b91c1c] text-white rounded-[2rem] shadow-2xl p-10 transition-all duration-500 hover:shadow-red-200/50">
                <div class="relative z-10">
                    <h3 class="text-4xl md:text-5xl font-black tracking-tighter uppercase">
                        Halo, <span class="text-[#E7BD8A]">{{ Auth::user()->name }}</span>
                    </h3>
                    <p class="mt-3 text-red-100 text-lg font-medium opacity-90 italic">
                        Panel Kendali Operasional TJ&T Mart — Selamat bekerja!
                    </p>
                </div>
                {{-- Dekorasi Latar Belakang --}}
                <div class="absolute top-0 right-0 -mt-12 -mr-12 w-64 h-64 bg-white opacity-5 rounded-full"></div>
            </div>

            {{-- STATS GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Total Produk --}}
                <div class="stat-card bg-white rounded-2xl shadow-sm p-6 border-t-4 border-[#dc2626] flex flex-col justify-between">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Produk</p>
                    <div class="flex items-end justify-between mt-2">
                        <h4 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $totalProduk }}</h4>
                        <span class="text-xs font-bold text-gray-400 uppercase">Item</span>
                    </div>
                </div>

                {{-- Pesanan Masuk --}}
                <div class="stat-card bg-white rounded-2xl shadow-sm p-6 border-t-4 border-orange-500 flex flex-col justify-between">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Pesanan Masuk</p>
                    <div class="flex items-end justify-between mt-2">
                        <h4 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $pesananMasuk }}</h4>
                        <div class="p-1.5 bg-orange-50 text-orange-600 rounded-lg">
                            <i class="fas fa-shopping-cart text-sm"></i>
                        </div>
                    </div>
                </div>

                {{-- Produk Habis --}}
                <div class="stat-card bg-white rounded-2xl shadow-sm p-6 border-t-4 border-[#5B000B] flex flex-col justify-between">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Produk Habis</p>
                    <div class="flex items-end justify-between mt-2">
                        <h4 class="text-4xl font-black text-[#dc2626] tracking-tighter">{{ $stokHabis }}</h4>
                        <span class="px-2 py-1 bg-red-50 text-[10px] font-black text-red-600 rounded uppercase">Alert</span>
                    </div>
                </div>

                {{-- Omset --}}
                <div class="stat-card bg-white rounded-2xl shadow-sm p-6 border-t-4 border-black flex flex-col justify-between">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Omset Bulan Ini</p>
                    <div class="mt-2">
                        <h4 class="text-2xl font-black text-slate-800 tracking-tight leading-none">
                            <span class="text-xs text-gray-400">Rp</span> {{ number_format($penjualanBulanIni, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            {{-- QUICK MENU TITLE --}}
            <div class="flex items-center gap-3 px-2">
                <span class="w-2 h-8 bg-[#dc2626] rounded-full"></span>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest">
                    Menu Navigasi Cepat
                </h3>
            </div>

            {{-- QUICK MENU GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Kelola Produk --}}
                <a href="{{ route('admin.produk.index') }}"
                   class="group bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-red-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-4 bg-red-50 text-[#dc2626] rounded-2xl group-hover:bg-[#dc2626] group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <i class="fas fa-arrow-right text-[#dc2626] opacity-0 arrow-icon transition-all duration-300"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 group-hover:text-[#dc2626] transition-colors uppercase tracking-tighter">Kelola Produk</h4>
                    <p class="text-gray-400 text-xs mt-2 font-medium">Inventori & Update Stok</p>
                </a>

                {{-- Kategori --}}
                <a href="{{ route('admin.kategori.index') }}"
                   class="group bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-red-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-4 bg-orange-50 text-orange-600 rounded-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <i class="fas fa-arrow-right text-orange-600 opacity-0 arrow-icon transition-all duration-300"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 group-hover:text-orange-600 transition-colors uppercase tracking-tighter">Kategori</h4>
                    <p class="text-gray-400 text-xs mt-2 font-medium">Grouping & Klasifikasi</p>
                </a>

                {{-- Pesanan --}}
                <a href="{{ route('admin.pesanan.index') }}"
                   class="group bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-red-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                        </div>
                        <i class="fas fa-arrow-right text-blue-600 opacity-0 arrow-icon transition-all duration-300"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 group-hover:text-blue-600 transition-colors uppercase tracking-tighter">Pesanan</h4>
                    <p class="text-gray-400 text-xs mt-2 font-medium">Proses Transaksi Masuk</p>
                </a>

                {{-- Laporan --}}
                <a href="{{ route('admin.produk.laporan.index') }}"
                   class="group bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:border-red-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-4 bg-gray-50 text-gray-800 rounded-2xl group-hover:bg-black group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <i class="fas fa-arrow-right text-black opacity-0 arrow-icon transition-all duration-300"></i>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 group-hover:text-black transition-colors uppercase tracking-tighter">Laporan</h4>
                    <p class="text-gray-400 text-xs mt-2 font-medium">Rekap Penjualan Bulanan</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>