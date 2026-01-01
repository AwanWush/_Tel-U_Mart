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
            color: #dc2626; /* Primary Accent (Mengganti #dc2626) */
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
        .border-status-success { border-color: #5B000B; } /* Menggunakan Primary Accent */
        .text-status-success { color: #dc2626; } /* Menggunakan Dark Accent */
        
        /* Pending / Diproses */
        .bg-status-pending { background-color: #fef9c3; } /* Yellow-100/200 */
        .border-status-pending { border-color: #E68757; } /* Menggunakan Secondary */
        .text-status-pending { color: #E68757; } /* Menggunakan Secondary */
        
        /* Dibatalkan */
        .bg-status-cancelled { background-color: #FEE2E2; } /* Red Soft */
        .border-status-cancelled { border-color: #930014; } /* Deep Accent */
        .text-status-cancelled { color: #930014; } /* Deep Accent */

        /* === DITAMBAHKAN: Styling untuk Tombol Cetak/Aksi Sekunder === */
        .btn-secondary-soft {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #930014; /* Secondary */
            border-color: #930014; /* Soft Accent */
        }
        .btn-secondary-soft:hover {
            border-color: #dc2626;
            background-color: white; /* Soft Accent */
            color: #dc2626; /* Dark Accent */
            box-shadow: 4 8px 30px rgba(231, 189, 138, 0.5); /* Soft Accent Shadow */
        }
    </style>

    <x-slot name="header">
        {{-- DIUBAH: Menyesuaikan container header agar sama dengan galon.history --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-2">
            {{-- DITAMBAHKAN: Breadcrumb dengan path dashboard > riwayat pembalian galon > detail pesanan --}}
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse text-sm">
                    <li class="inline-flex items-center">
                        {{-- Link ke Dashboard --}}
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-primary-accent transition-colors">
                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        {{-- Link ke Riwayat Pembelian Galon --}}
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('galon.history') }}" class="ms-1 text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-primary-accent transition-colors">
                                Riwayat Pembelian Galon
                            </a>
                        </div>
                    </li>
                    <li>
                        {{-- Halaman Aktif: Detail Pesanan --}}
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-primary-accent">Detail Pesanan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            {{-- DIUBAH: CONTAINER UTAMA: Tombol Kembali (Ikon) dan Judul Halaman --}}
            <div class="flex items-center mt-4">
                {{-- Tombol Kembali ke Galon History (Hanya Ikon) --}}
                <a href="{{ route('galon.history') }}" 
                    class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-primary-accent active:scale-[0.98]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>

                {{-- DIUBAH: Judul Halaman (Disesuaikan seperti galon.history) --}}
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight tracking-tight uppercase">
                    Detail <span class="text-primary-accent">Pesanan</span>
                </h1>
            </div>
            {{-- DIHAPUS: Judul lama dengan ID transaksi yang berada di sini --}}
        </div>
    </x-slot>

    {{-- Background Utama: Menggunakan bg-gray-50 seperti galon.history --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            {{-- Mengganti struktur card detail agar senada dengan card di galon.history --}}
            <div class="bg-white rounded-[2.5rem] border-2 border-gray-200 shadow-2xl shadow-gray-300/50 overflow-hidden relative">
                
                {{-- DIUBAH: Bagian Ringkasan dan Ikon --}}
                <div class="p-10 pb-6 flex flex-col items-center border-b border-gray-100"> 
                    {{-- DITAMBAHKAN: Wrapper untuk mengatur gap dan style atas --}}
                    
                    {{-- Ikon Ringkasan --}}
                    {{-- DIUBAH: Ikon menggunakan warna Primary Accent, bukan Deep Accent, untuk lebih cerah --}}
                    <div class="h-16 w-16 bg-red-soft rounded-full flex items-center justify-center mb-6 border-4 border-red-soft/50 shadow-md shadow-red-100">
                        <svg class="w-8 h-8 text-primary-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 21v-4a2 2 0 012-2h0a2 2 0 012 2v4M12 22s8-4 8-10V5L12 2 4 5v7c0 6 8 10 8 10zM12 17c1.38 0 2.5-1.12 2.5-2.5s-1.12-2.5-2.5-2.5-2.5 1.12-2.5 2.5 1.12 2.5 2.5 2.5z"></path>
                        </svg>
                    </div>

                    {{-- DIUBAH: Judul menggunakan Primary Accent untuk konsistensi --}}
                    <h3 class="text-4xl font-black text-gray-900 tracking-tight uppercase">Ringkasan <span class="text-primary-accent">Pesanan</span></h3>
                    
                    {{-- DIUBAH: Dipesan pada --}}
                    <p class="text-gray-400 text-xs mt-2 font-medium uppercase tracking-widest">Dipesan pada: {{ $transaksi->created_at->format('d F Y • H:i') }}</p>

                    {{-- DITAMBAHKAN: ID Transaksi --}}
                    <p class="text-gray-500 text-sm mt-1">ID Transaksi: #{{ $transaksi->id }}</p>
                    
                </div>

                <div class="p-10 pt-6 space-y-4"> {{-- DIUBAH: pt-6 sedikit dikecilkan karena sudah ada padding di atas --}}
                    
                    {{-- Status Transaksi (Menggunakan palet warna konsisten) --}}
                    {{-- DIUBAH: Status dibuat lebih menonjol dengan label --}}
                    <div class="flex flex-col items-center justify-center gap-2">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Status Pesanan:</span>
                        @php
                            $statusClass = '';
                            $displayText = ucfirst($transaksi->status);
                            if (strtolower($transaksi->status) == 'selesai' || strtolower($transaksi->status) == 'paid') {
                                $statusClass = 'bg-status-success text-status-success border border-status-success/50';
                                $displayText = 'Selesai / Lunas';
                            } elseif (strtolower($transaksi->status) == 'pending' || strtolower($transaksi->status) == 'diproses') {
                                $statusClass = 'bg-status-pending text-status-pending border border-status-pending/50';
                                $displayText = ucfirst($transaksi->status);
                            } elseif (strtolower($transaksi->status) == 'dibatalkan') {
                                $statusClass = 'bg-status-cancelled text-status-cancelled border border-status-cancelled/50';
                                $displayText = 'Dibatalkan';
                            } else {
                                $statusClass = 'bg-gray-100 text-gray-500 border border-gray-300';
                            }
                        @endphp
                        {{-- DIUBAH: Padding dan ukuran font disesuaikan --}}
                        <span class="px-6 py-2 rounded-full text-xs font-black uppercase tracking-wider {{ $statusClass }} shadow-lg shadow-gray-100">
                            {{ $displayText }}
                        </span>
                    </div>

                    {{-- Detail Item dan Harga --}}
                    {{-- DIUBAH: Struktur diperjelas, garis dipindah di antara bagian, bukan membingkai --}}
                    <div class="space-y-4 border-y border-gray-100 py-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Produk</span>
                            <span class="text-[#5B000B] font-medium text-sm">{{ $transaksi->nama_galon }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Harga Satuan</span>
                            <span class="text-[#5B000B] font-medium text-sm">Rp{{ number_format($transaksi->harga_satuan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Jumlah</span>
                            <span class="text-[#5B000B] font-medium text-sm">{{ $transaksi->jumlah }} Galon</span>
                        </div>
                        <div class="pt-4 flex justify-between items-center">
                            <span class="text-[#E68757] font-bold text-xs uppercase tracking-widest">Total Bayar</span>
                            <span class="text-2xl font-black text-[#dc2626] tracking-tight">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-col gap-3 pt-1">
                        {{-- Tombol Cetak Bukti (Aksi Sekunder) --}}
                        @if(strtolower($transaksi->status) == 'selesai' || strtolower($transaksi->status) == 'paid')
                        <button onclick="window.print()" 
                            class="btn-secondary-soft w-full py-3 bg-white text-xs font-black rounded-xl border-2 uppercase tracking-widest active:scale-[0.98] shadow-md hover:shadow-xl hover:shadow-soft-accent/50"> 
                            {{-- DIUBAH: Menggunakan kelas kustom .btn-secondary-soft --}}
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m0 0v1a2 2 0 002 2h6a2 2 0 002-2v-1m-8 0V9a2 2 0 012-2h2a2 2 0 012 2v8"></path>
                                </svg>
                                Cetak Bukti Pembayaran
                            </span>
                        </button>
                        @endif
                        
                        {{-- Tombol Utama: Kembali atau Bayar Sekarang --}}
                        <a href="{{ route('galon.history') }}"
                            class="w-full py-4 bg-[#930014] text-white text-xs font-bold rounded-xl text-center hover:bg-[#dc2626] transition-all tracking-widest">
                            KEMBALI KE RIWAYAT
                        </a>
                    </div>
                </div>

            {{-- Footer (Disesuaikan seperti di galon.history) --}}
            {{-- DIUBAH: mt-16 (margin top besar) menjadi mt-8 untuk mengurangi jarak secara signifikan. --}}
            <footer class="mt-1 py-10 border-t border-gray-200 text-center px-4 sm:px-0">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em]">&copy; {{ date('Y') }} TJ-T Mart Smart Energy System</p>
            </footer>
        </div>
    </div>
</x-app-layout>