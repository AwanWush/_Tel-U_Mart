<x-app-layout>
    {{-- Hapus semua Custom Stylesheet yang redundant, biarkan yang khusus (history-card dan btn-struk-digital) --}}
    <style>
        /* Styling khusus untuk Riwayat Card */
        .history-card {
            transition: all 0.5s cubic-bezier(0.25, 0, 0.25, 1);
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

        /* Tambahkan Styling Icon Only dari token page untuk Tombol Kembali */
        .btn-back-icon-only {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent; 
            color: #dc2626; /* text-red-main */
        }
        .btn-back-icon-only:hover {
            color: #b91c1c; /* text-red-hover */
            transform: translateX(-3px); 
        }
        
        /* === DITAMBAHKAN: Style warna utama dari token page === */
        .bg-red-main { background-color: #dc2626; }
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        .bg-red-soft { background-color: #fee2e2; }
    </style>

    {{-- ⚡ Header untuk Halaman Riwayat (Diselaraskan dengan Token Page Header) ⚡ --}}
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-2">
            {{-- Breadcrumb --}}
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse text-sm">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-red-main transition-colors">
                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-red-main">Riwayat Transaksi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            {{-- CONTAINER UTAMA: Tombol Kembali (Ikon) dan Judul Halaman --}}
            <div class="flex items-center mt-4">
                {{-- Tombol Kembali ke Token Page (Hanya Ikon) --}}
                <button onclick="window.history.back()"
                    class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-red-main active:scale-[0.98]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </button>

                {{-- Judul Halaman --}}
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight tracking-tight uppercase">
                    Riwayat <span class="text-red-main">Pembelian Token</span>
                </h1>
            </div>
        </div>
    </x-slot>

    {{-- Background Utama: Putih Bersih (Sama seperti halaman token) --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ filterStatus: 'semua' }">

             
             {{-- Container Daftar Transaksi (Diubah ke Light Mode) --}}
             <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-2xl shadow-gray-300/50 mx-4 sm:mx-0">
                 {{-- Judul (Daftar Transaksi dipindahkan ke Body) --}}
                 <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6 px-4 sm:px-0">
                     <div>
                         {{-- PERUBAHAN JUDUL: Lebih besar, bold, dan menonjol --}}
                         <h3 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Daftar <span class="text-red-main">Transaksi</span></h3>
                         {{-- PENAMBAHAN DESKRIPSI: Font medium dan italic --}}
                         <p class="text-gray-500 mt-2 font-medium italic">Pantau dan simpan kode token listrik Anda di sini.</p>
                     </div>
                 </div>
                 @if ($riwayat->isEmpty())
                    {{-- Blok ini sudah bagus, hanya memastikan penggunaan warna yang baru (text-red-main, bg-red-soft) --}}
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
                                            {{-- Waktu Transaksi --}}
                                            <p class="text-[10px] font-black text-red-main uppercase tracking-[0.2em] mb-1">
                                                {{ $r->created_at ? $r->created_at->format('d M Y • H:i') : '-' }}
                                            </p>
                                            {{-- Nominal Pembelian --}}
                                            <h4 class="text-2xl font-black text-gray-900 group-hover:text-red-main transition-colors tracking-tighter">
                                                Rp{{ number_format($r->total_harga, 0, ',', '.') }}
                                            </h4>
                                            
                                            {{-- LOGIKA PENGAMBILAN KODE TOKEN (Kode PHP tidak diubah) --}}
                                            @php 
                                                // Mengambil kode dari tabel detail_pembelian tubes_pbw2
                                                $detail = DB::table('detail_pembelian')->where('riwayat_pembelian_id', $r->id)->first();
                                                $kodeToken = null;
                                                if ($detail && str_contains($detail->nama_produk, 'Token:')) {
                                                    $kodeToken = Str::before(Str::after($detail->nama_produk, 'Token: '), ' ('); 
                                                }
                                            @endphp

                                            @if($kodeToken && $r->status == 'Lunas')
                                                {{-- Token Display (Penyempurnaan tampilan kode token) --}}
                                                <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-lg border border-gray-200">
                                                    <span class="font-mono text-xs text-red-main font-bold tracking-[0.2em]">{{ $kodeToken }}</span>
                                                </div>
                                            @endif

                                            {{-- Tampilan Status (Dibuat lebih menonjol) --}}
                                            <div class="flex items-center gap-3 mt-3"> {{-- DIUBAH: margin-top ditingkatkan menjadi mt-3 --}}
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
                                        <a href="{{ route('token.result', $r->id) }}"
                                            class="btn-struk-digital group flex items-center justify-center gap-2 w-full md:w-auto px-8 py-3 bg-white text-gray-900 font-black rounded-xl border-2 border-red-main/50 shadow-lg shadow-red-main/10 active:scale-95 hover:bg-red-main hover:text-white">
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
            <footer class="mt-16 py-10 border-t border-gray-200 text-center px-4 sm:px-0">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em]">&copy; {{ date('Y') }} TJ-T Mart Smart Energy System</p>
            </footer>

        </div>
    </div>
</x-app-layout>