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
        
        /* Tambahan Palet untuk Status (SUCCESS: Berhasil / Lunas) */
        .bg-status-success { background-color: #fee2e2; } /* Menggunakan Red Soft (#fee2e2) */
        .border-status-success { border-color: #DB4B3A; } /* Menggunakan Primary Accent (#DB4B3A) */
        .text-status-success { color: #930014; } /* Menggunakan Deep Accent (#930014) */
        
        /* Tambahan Palet untuk Status (PENDING / Gagal) */
        /* Untuk Pending, kita gunakan palet Kuning/Oranye yang lebih soft */
        .bg-status-pending { background-color: #fef9c3; } /* Yellow-100/200 */
        .border-status-pending { border-color: #E68757; } /* Menggunakan Secondary (#E68757) */
        .text-status-pending { color: #E68757; } /* Menggunakan Secondary (#E68757) */
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

                                {{-- START: PERUBAHAN ISI CARD TRANSAKSI --}}
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                                    
                                    {{-- Kiri: Detail Transaksi --}}
                                    <div class="flex gap-4 items-start">
                                        
                                        {{-- Icon Power (Diubah ke skema warna merah dan Deep Accent untuk shadow) --}}
                                        <div class="h-14 w-14 flex-shrink-0 rounded-xl flex items-center justify-center bg-[#fee2e2] text-[#930014] border border-[#dc2626]/20 shadow-md shadow-[#fee2e2]">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>

                                        <div>
                                            {{-- Nominal Pembelian (Menjadi Judul Utama) --}}
                                            <h4 class="text-3xl font-black text-gray-900 tracking-tighter">
                                                Rp{{ number_format($r->total_harga, 0, ',', '.') }}
                                            </h4>
                                            
                                            {{-- Waktu Transaksi (Lebih soft) --}}
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">
                                                Tanggal: {{ $r->created_at ? $r->created_at->format('d M Y') : '-' }} • Pukul: {{ $r->created_at ? $r->created_at->format('H:i') : '-' }}
                                            </p>

                                            {{-- Tampilan Status (Dibuat lebih menonjol dan menggunakan warna palet) --}}
                                            <div class="flex items-center gap-3 mt-3">
                                                {{-- Text: Status: --}}
                                                <span class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Status:</span>
                                                
                                                {{-- Chip Status yang Diperbarui --}}
                                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                                    @if($r->status == 'Lunas') 
                                                        bg-status-success text-status-success border border-status-success/50
                                                    @else 
                                                        bg-status-pending text-status-pending border border-status-pending/50
                                                    @endif">
                                                    {{ $r->status == 'Lunas' ? 'Berhasil' : $r->status }}
                                                </span>
                                            </div>
                                            
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
                                                <div class="mt-4">
                                                    <span class="block text-xs font-extrabold uppercase tracking-widest text-[#DB4B3A] mb-1">Kode Token:</span>
                                                    {{-- Gunakan Soft Accent untuk kontras --}}
                                                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#E7BD8A]/30 rounded-xl border-2 border-[#E7BD8A]/50 shadow-inner shadow-gray-100/50">
                                                        {{-- Deep Accent untuk teks token --}}
                                                        <span class="font-mono text-base text-[#5B000B] font-bold tracking-[0.2em]">{{ $kodeToken }}</span>
                                                        {{-- Tambahkan tombol copy (Alpine.js) --}}
                                                        <button 
                                                            type="button" 
                                                            @click="navigator.clipboard.writeText('{{ $kodeToken }}'); $el.innerText = 'Tersalin!'; setTimeout(() => { $el.innerText = 'SALIN'; }, 1500)"
                                                            class="text-xs font-bold uppercase tracking-widest text-[#930014] hover:text-[#DB4B3A] transition-colors active:scale-95 ml-2"
                                                            x-init="$el.innerText = 'SALIN'">
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                    {{-- Kanan: Tombol Aksi --}}
                                    <div class="w-full md:w-auto mt-4 md:mt-0">
                                        {{-- Tombol Struk Digital (Diubah ke style tombol utama: putih-merah) --}}
                                        <a href="{{ route('token.result', $r->id) }}"
                                            class="btn-struk-digital group flex items-center justify-center gap-2 w-full md:w-auto px-8 py-3 bg-white text-gray-900 font-black rounded-xl border-2 border-[#DB4B3A]/50 shadow-lg shadow-[#DB4B3A]/10 active:scale-95 hover:bg-[#DB4B3A] hover:text-white transition-all duration-300 ease-in-out">
                                            STRUK DIGITAL
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                {{-- Dekorasi Background (Menggunakan Soft Accent dan Primary Accent) --}}
                                <div class="absolute -right-10 -bottom-10 h-32 w-32 bg-[#E7BD8A]/10 rounded-full blur-3xl group-hover:bg-[#DB4B3A]/10 transition-colors"></div>
                            </div>
                            {{-- END: PERUBAHAN ISI CARD TRANSAKSI --}}
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