<x-app-layout>
    <style>
        /* Styling khusus untuk Riwayat Card */
        .history-card {
            transition: all 0.5s cubic-bezier(0.25, 0, 0.25, 1);
            transform: translateZ(0);
        }
        /* Menggunakan Primary Accent untuk hover pada border dan shadow */
        .history-card:hover {
            box-shadow: 0 10px 25px rgba(219, 75, 58, 0.15); /* Primary Accent Shadow */
            border-color: #dc2626; /* Primary Accent */
            transform: translateY(-4px);
        }

        /* Styling untuk tombol DETAIL */
        .btn-detail-digital {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Menggunakan Deep Accent untuk hover */
        .btn-detail-digital:hover {
            background-color: #dc2626; /* Deep Accent */
            color: white;
            box-shadow: 0 5px 15px rgba(147, 0, 20, 0.4);
            transform: translateY(-1px);
        }

        /* Tambahkan Styling Icon Only dari token page untuk Tombol Kembali */
        .btn-back-icon-only {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent; 
            color: #DB4B3A; /* Primary Accent (Mengganti #dc2626) */
        }
        .btn-back-icon-only:hover {
            color: #930014; /* Deep Accent (Mengganti #b91c1c) */
            transform: translateX(-3px); 
        }
        
        /* === DITAMBAHKAN/DIUBAH: Style warna utama dari palet === */
        .bg-primary-accent { background-color: #dc2626; }
        .text-primary-accent { color: #dc2626; }
        .border-primary-accent { border-color: #dc2626; }
        
        .bg-red-soft { background-color: #fee2e2; }
        .border-red-soft { border-color: #fecaca; } /* Red Soft Lighter */

        /* Tambahan Palet untuk Status GALON */
        /* Berhasil / Selesai */
        .bg-status-success { background-color: #fee2e2; } /* Menggunakan Red Soft */
        .border-status-success { border-color: #DB4B3A; } /* Menggunakan Primary Accent */
        .text-status-success { color: #5B000B; } /* Menggunakan Dark Accent */
        
        /* Pending / Diproses */
        .bg-status-pending { background-color: #fef9c3; } /* Yellow-100/200 */
        .border-status-pending { border-color: #E68757; } /* Menggunakan Secondary */
        .text-status-pending { color: #E68757; } /* Menggunakan Secondary */
        
        /* Dibatalkan */
        .bg-status-cancelled { background-color: #FEE2E2; } /* Red Soft */
        .border-status-cancelled { border-color: #930014; } /* Deep Accent */
        .text-status-cancelled { color: #930014; } /* Deep Accent */
    </style>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-2">
            {{-- Breadcrumb --}}
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse text-sm">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-primary-accent transition-colors">
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
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-primary-accent">Riwayat Pembelian Galon</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            {{-- CONTAINER UTAMA: Tombol Kembali (Ikon) dan Judul Halaman --}}
            <div class="flex items-center mt-4">
                {{-- Tombol Kembali ke Galon Page (Hanya Ikon) --}}
                {{-- Menggunakan route galon.index (Asumsi ini adalah halaman awal pembelian galon) --}}
                <a href="{{ route('galon.index') }}" 
                    class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-primary-accent active:scale-[0.98]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>

                {{-- Judul Halaman (Disesuaikan untuk Galon) --}}
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight tracking-tight uppercase">
                    Riwayat <span class="text-primary-accent">Pembelian Galon</span>
                </h1>
            </div>
        </div>
    </x-slot>

    {{-- Background Utama: Putih Bersih --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ filterStatus: 'semua' }">

            {{-- Container Daftar Transaksi --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-200 shadow-2xl shadow-gray-300/50 mx-4 sm:mx-0">
                {{-- Judul Daftar Transaksi --}}
                <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6 px-4 sm:px-0">
                    <div>
                        <h3 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Daftar <span class="text-primary-accent">Transaksi</span></h3>
                        <p class="text-gray-500 mt-2 font-medium italic">Pantau status pesanan dan detail pembelian galon Anda di sini.</p>
                    </div>
                </div>
                
                @if ($riwayat->isEmpty())
                    {{-- Konten Kosong (Disesuaikan untuk Galon, menggunakan ikon galon/air) --}}
                    <div class="text-center py-20">
                        <div class="inline-flex p-6 bg-red-soft rounded-full mb-4 border border-red-soft/50 shadow-md shadow-red-100">
                            {{-- Ikon Galon (Diambil dari Token Page, diubah untuk merepresentasikan Galon) --}}
                            <svg class="w-12 h-12 text-primary-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22s8-4 8-10V5L12 2 4 5v7c0 6 8 10 8 10zM12 17c1.38 0 2.5-1.12 2.5-2.5s-1.12-2.5-2.5-2.5-2.5 1.12-2.5 2.5 1.12 2.5 2.5 2.5zM12 14v-2"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-bold text-lg uppercase tracking-widest mt-4">Belum ada transaksi galon.</p>
                        <p class="text-gray-400 font-medium mt-2">Yuk, pesan galon pertama Anda!</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($riwayat as $r)
                            {{-- Card Transaksi Galon (Diperbarui) --}}
                            <div class="history-card relative overflow-hidden bg-white p-6 rounded-3xl border-2 border-gray-200 shadow-lg shadow-gray-100"
                                x-show="filterStatus === 'semua' || filterStatus === '{{ $r->status }}'"
                                x-transition:enter="transition transform duration-500"
                                x-transition:enter-start="opacity-0 translate-y-4">

                                {{-- START: ISI CARD TRANSAKSI --}}
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                                    
                                    {{-- Kiri: Detail Transaksi --}}
                                    <div class="flex gap-4 items-start">
                                        
                                        {{-- Icon Galon (Disesuaikan) --}}
                                        <div class="h-14 w-14 flex-shrink-0 rounded-xl flex items-center justify-center bg-[#fee2e2] text-[#930014] border border-primary-accent/20 shadow-md shadow-[#fee2e2]">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21v-4a2 2 0 012-2h0a2 2 0 012 2v4M12 22s8-4 8-10V5L12 2 4 5v7c0 6 8 10 8 10zM12 17c1.38 0 2.5-1.12 2.5-2.5s-1.12-2.5-2.5-2.5-2.5 1.12-2.5 2.5 1.12 2.5 2.5 2.5z"></path>
                                            </svg>
                                        </div>

                                        <div>
                                            {{-- Jenis Galon dan Jumlah --}}
                                            <h4 class="text-xl font-black text-gray-900 tracking-tight">
                                                {{ $r->nama_galon }} ({{ $r->jumlah }} Galon)
                                            </h4>
                                            
                                            {{-- Total Harga --}}
                                            <p class="text-sm font-black text-[#930014] mt-1">
                                                Total: Rp{{ number_format($r->total_harga, 0, ',', '.') }}
                                            </p>

                                            {{-- Waktu Transaksi --}}
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-2">
                                                Tanggal: {{ $r->created_at ? $r->created_at->format('d M Y') : '-' }} • Pukul: {{ $r->created_at ? $r->created_at->format('H:i') : '-' }}
                                            </p>

                                            {{-- Tampilan Status (Dibuat lebih menonjol dan menggunakan warna palet) --}}
                                            <div class="flex items-center gap-3 mt-3">
                                                {{-- Text: Status: --}}
                                                <span class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Status:</span>
                                                
                                                {{-- Chip Status yang Diperbarui --}}
                                                @php
                                                    $statusClass = '';
                                                    $displayText = ucfirst($r->status);
                                                    if (strtolower($r->status) == 'paid') {
                                                        $statusClass = 'bg-status-success text-status-success border border-status-success/50';
                                                        $displayText = 'Lunas';
                                                    } elseif (strtolower($r->status) == 'pending' || strtolower($r->status) == 'diproses') {
                                                        $statusClass = 'bg-status-pending text-status-pending border border-status-pending/50';
                                                        $displayText = ucfirst($r->status);
                                                    } elseif (strtolower($r->status) == 'dibatalkan') {
                                                        $statusClass = 'bg-status-cancelled text-status-cancelled border border-status-cancelled/50';
                                                        $displayText = 'Dibatalkan';
                                                    } else {
                                                        $statusClass = 'bg-gray-100 text-gray-500 border border-gray-300';
                                                    }
                                                @endphp

                                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusClass }}">
                                                    {{ $displayText }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Kanan: Tombol Aksi --}}
                                    <div class="w-full md:w-auto mt-4 md:mt-0">
                                        {{-- Tombol Detail Transaksi (Diubah ke btn-detail-digital) --}}
                                        <a href="{{ route('galon.detail', $r->id) }}"
                                            class="btn-detail-digital group flex items-center justify-center gap-2 w-full md:w-auto px-8 py-3 bg-white text-gray-900 font-black rounded-xl border-2 border-primary-accent/50 shadow-lg shadow-primary-accent/10 active:scale-95 hover:bg-primary-accent hover:text-white transition-all duration-300 ease-in-out">
                                            DETAIL PESANAN
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                {{-- Dekorasi Background (Menggunakan Soft Accent dan Primary Accent) --}}
                                <div class="absolute -right-10 -bottom-10 h-32 w-32 bg-[#E7BD8A]/10 rounded-full blur-3xl group-hover:bg-[#DB4B3A]/10 transition-colors"></div>
                            </div>
                            {{-- END: ISI CARD TRANSAKSI --}}
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