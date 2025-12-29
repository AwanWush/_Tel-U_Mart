<x-app-layout>
    {{-- Custom Stylesheet dari halaman Token --}}
    <style>
        .bg-primary-accent { background-color: #DB4B3A; }
        .text-primary-accent { color: #DB4B3A; }
        .border-primary-accent { border-color: #DB4B3A; }
        
        /* WARNA UTAMA */
        .bg-red-main { background-color: #dc2626; }
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        
        .hover\:bg-red-hover:hover { background-color: #b91c1c; }
        .shadow-red-soft { box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); }
        .text-soft-accent { color: #E7BD8A; }
        .bg-red-soft { background-color: #fee2e2; }
        .text-red-soft-darker { color: #fecaca; }
        .border-soft-accent { border-color: #E7BD8A; }

        /* Styling khusus untuk Riwayat Card */
        .history-card {
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            transform: translateZ(0);
        }
        .history-card:hover {
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.15);
            border-color: #dc2626;
            transform: translateY(-4px);
        }

        /* Styling untuk tombol STRUK DIGITAL */
        .btn-struk-digital {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-struk-digital:hover {
            background-color: #dc2626; /* bg-red-main */
            color: white;
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.4);
            transform: translateY(-1px);
        }
    </style>

    {{-- ⚡ Header untuk Halaman Riwayat (Diperbarui dengan Tombol Back & Breadcrumb) ⚡ --}}
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Tombol Kembali --}}
            <button onclick="window.history.back()"
                class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-red-main transition duration-150 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </button>

            {{-- Breadcrumb --}}
            <nav class="flex text-gray-400 text-xs font-medium tracking-wider uppercase mb-2">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-red-main">
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-300 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="text-gray-700">Riwayat Transaksi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- Judul Halaman Utama --}}
            <h2 class="font-black text-3xl text-gray-800 leading-tight tracking-tight uppercase">
                Riwayat <span class="text-red-main">Pembelian Token</span>
            </h2>
        </div>
    </x-slot>

    {{-- Background Utama: Putih Bersih (Sama seperti halaman token) --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
              x-data="{ filterStatus: 'semua' }">

            {{-- Header & Filter Interaktif (Daftar Transaksi dipindahkan ke Body) --}}
            <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
                <div>
                    <h3 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Daftar <span class="text-red-main">Transaksi</span></h3>
                    <p class="text-gray-500 mt-2 font-medium italic">Pantau dan simpan kode token listrik Anda di sini.</p>
                </div>
                
                {{-- Filter Tab Modern (Diubah ke skema warna merah) --}}
                <div class="flex bg-white p-1.5 rounded-xl border border-gray-200 shadow-xl shadow-gray-200/50">
                    <button @click="filterStatus = 'semua'" 
                            :class="filterStatus === 'semua' ? 'bg-red-main text-white shadow-lg shadow-red-main/50' : 'text-gray-500 hover:text-gray-900'"
                            class="px-6 py-2 rounded-lg text-xs font-black uppercase transition-all duration-300">Semua</button>
                    <button @click="filterStatus = 'Lunas'" 
                            :class="filterStatus === 'Lunas' ? 'bg-green-600 text-white shadow-lg shadow-green-600/50' : 'text-gray-500 hover:text-gray-900'"
                            class="px-6 py-2 rounded-lg text-xs font-black uppercase transition-all duration-300">Berhasil</button>
                </div>
            </div>

            {{-- Container Daftar Transaksi (Diubah ke Light Mode) --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-2xl shadow-gray-300/50">
                @if ($riwayat->isEmpty())
                    <div class="text-center py-20">
                        <div class="inline-flex p-6 bg-red-soft rounded-full mb-4 border border-red-200/50 shadow-md shadow-red-100">
                            <svg class="h-12 w-12 text-red-main" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-bold text-lg uppercase tracking-widest mt-4">Belum ada transaksi token.</p>
                        <p class="text-gray-400 font-medium mt-2">Yuk, beli token pertama Anda!</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($riwayat as $r)
                            {{-- Card Transaksi (Diperbarui) --}}
                            <div class="history-card relative overflow-hidden bg-white p-6 rounded-3xl border-2 border-gray-200 shadow-lg shadow-gray-100"
                                 x-show="filterStatus === 'semua' || filterStatus === '{{ $r->status }}'"
                                 x-transition:enter="transition transform duration-500"
                                 x-transition:enter-start="opacity-0 translate-y-4">

                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                                    <div class="flex gap-5 items-center">
                                        {{-- Icon Power (Diubah ke skema warna merah) --}}
                                        <div class="h-14 w-14 rounded-2xl flex items-center justify-center bg-red-main/10 text-red-main border border-red-main/20 shadow-inner shadow-red-100">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="text-[10px] font-black text-red-main uppercase tracking-[0.2em] mb-1">
                                                {{ $r->created_at ? $r->created_at->format('d M Y • H:i') : '-' }}
                                            </p>
                                            <h4 class="text-2xl font-black text-gray-900 group-hover:text-red-main transition-colors tracking-tighter">
                                                Rp{{ number_format($r->total_harga, 0, ',', '.') }}
                                            </h4>
                                            
                                            {{-- LOGIKA PENGAMBILAN KODE TOKEN --}}
                                            @php 
                                                // Mengambil kode dari tabel detail_pembelian tubes_pbw2
                                                $detail = DB::table('detail_pembelian')->where('riwayat_pembelian_id', $r->id)->first();
                                                $kodeToken = null;
                                                if ($detail && str_contains($detail->nama_produk, 'Token:')) {
                                                    $kodeToken = Str::before(Str::after($detail->nama_produk, 'Token: '), ' ('); 
                                                }
                                            @endphp

                                            @if($kodeToken && $r->status == 'Lunas')
                                                {{-- Token Display (Diubah ke Light Mode) --}}
                                                <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-lg border border-gray-200">
                                                    <span class="font-mono text-xs text-red-main font-bold tracking-[0.2em]">{{ $kodeToken }}</span>
                                                </div>
                                            @endif

                                            <div class="flex items-center gap-3 mt-2">
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Status:</span>
                                                <span class="px-3 py-0.5 rounded-lg text-[10px] font-black uppercase border
                                                     @if($r->status == 'Lunas') border-green-500/50 text-green-700 bg-green-500/10
                                                     @else border-yellow-500/50 text-yellow-700 bg-yellow-500/10 @endif">
                                                     {{ $r->status == 'Lunas' ? 'Berhasil' : $r->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full md:w-auto">
                                        {{-- Tombol Struk Digital (Diubah ke style tombol utama: putih-merah) --}}
                                        <a href="{{ route('order.success', ['order_id' => $r->id_transaksi, 'status' => 'paid', 'type' => 'token', 'amount' => $r->total_harga]) }}"
                                            class="btn-struk-digital group flex items-center justify-center gap-2 w-full md:w-auto px-8 py-3 bg-white text-gray-900 font-black rounded-xl border-2 border-red-main/50 shadow-lg shadow-red-main/10 active:scale-95">
                                            STRUK DIGITAL
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                {{-- Dekorasi Background (Diubah ke skema warna merah) --}}
                                <div class="absolute -right-10 -bottom-10 h-32 w-32 bg-red-main/5 rounded-full blur-3xl group-hover:bg-red-main/10 transition-colors"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Footer (Diubah ke Light Mode) --}}
            <footer class="mt-16 py-10 border-t border-gray-200 text-center">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em]">&copy; {{ date('Y') }} TJ-T Mart Smart Energy System</p>
            </footer>

        </div>
    </div>
</x-app-layout>