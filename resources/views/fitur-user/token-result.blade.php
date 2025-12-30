<x-app-layout>
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
        .bg-red-soft { background-color: #fee2e2; }
        .border-soft-accent { border-color: #E7BD8A; }

        /* Styling Struk/Card Utama Hasil: Menggunakan gaya card ringan dan struk */
        .receipt-container {
            background-color: #ffffff; 
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.1); 
            border-radius: 2.5rem; /* Mirip dengan card di token */
            border: 2px solid #fca5a5; /* border-red-300 */
        }
        
        /* Efek sobekan kertas atas/bawah (untuk visual hasil) */
        .receipt-top-tear {
            border-top: 3px dashed #fca5a5; /* border-red-300 */
            position: relative;
            margin: 1.5rem 0;
        }
        
        .receipt-top-tear::before, .receipt-top-tear::after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background-color: #f9fafb; /* Sesuaikan dengan bg outer div */
            border: 2px solid #fca5a5;
            border-radius: 50%;
            z-index: 10;
        }
        .receipt-top-tear::before {
            left: -10px;
        }
        .receipt-top-tear::after {
            right: -10px;
        }
        /* Ganti bg-gray-50 di struk dengan bg-white atau #f9fafb agar lubang terlihat */
        .receipt-content-bg {
            background-color: #f9fafb;
        }

        /* Styling untuk tombol Selesai/Kembali */
        .btn-pay-red {
            background-color: #dc2626; /* bg-red-main */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
        }
        .btn-pay-red:hover {
            background-color: #b91c1c; /* hover:bg-red-hover */
            /* PENGUATAN EFEK BAYANGAN */
            box-shadow: 0 14px 25px rgba(220, 38, 38, 0.5); 
            transform: translateY(-4px); /* Efek lift yang lebih tinggi */
        }

        /* Styling untuk tombol Cetak (DIENCHANT) */
        .btn-print-style {
            background-color: #ffffff;
            color: #374151; /* text-gray-700 */
            border: 2px solid #e5e7eb; /* border-gray-200 */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
        }
        .btn-print-style:hover {
            background-color: #f3f4f6; /* hover:bg-gray-100 */
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15); /* Bayangan lebih menonjol */
            border-color: #d1d5db; /* border-gray-300 */
            transform: translateY(-3px); /* Efek lift */
        }

        /* Menghilangkan elemen saat print */
        @media print {
            /* Sembunyikan tombol cetak dan selesai */
            .print-hidden {
                display: none !important;
            }
            /* Ubah latar belakang card utama menjadi putih */
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
            }
            /* Hilangkan dekorasi sobekan jika diperlukan */
            .receipt-top-tear {
                border-top: none !important;
                margin: 0 !important;
            }
            .receipt-top-tear::before, .receipt-top-tear::after {
                display: none !important;
            }
        }
        
        /* BARU DITAMBAHKAN DARI TOKEN PAGE UNTUK KONSISTENSI HEADER */
        .btn-back-icon-only {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent; /* Tambahkan border transparan */
            color: #dc2626; /* text-red-main */
        }
        .btn-back-icon-only:hover {
            color: #b91c1c; /* text-red-hover */
            transform: translateX(-3px); /* Sedikit efek bergerak ke kiri */
        }
        .btn-history-style {
            transition: all 0.3s ease;
            transform: translateZ(0); /* Force hardware acceleration */
        }
        .btn-history-style:hover {
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
            border-color: #dc2626;
            transform: translateY(-2px);
        }
    </style>

    {{-- Header untuk Light Mode (Diubah total) --}}
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
                            <a href="{{ route('token.index') }}" class="ms-1 text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-red-main transition-colors">Beli Token</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-red-main">Hasil Transaksi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- CONTAINER UTAMA: Tombol Kembali, Judul Halaman, dan Tombol Riwayat Transaksi --}}
            <div class="flex items-center justify-between mt-4">
                
                {{-- Bagian Kiri: Tombol Kembali (Ikon) dan Judul Halaman --}}
                <div class="flex items-center">
                    {{-- Tombol Kembali ke Token Page (Hanya Ikon) --}}
                    <a href="{{ route('token.index') }}"
                        class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-red-main active:scale-[0.98]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    
                    {{-- Judul Halaman --}}
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                        <span class="text-red-main">HASIL</span> <span class="text-black">TOKEN</span>
                    </h1>
                </div>

                {{-- Bagian Kanan: Tombol Riwayat Transaksi --}}
                <a href="{{ route('token.history') }}"
                    class="btn-history-style inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-white border-2 border-red-main/50 rounded-xl font-bold text-xs sm:text-sm text-red-main uppercase tracking-widest shadow-lg shadow-red-soft active:scale-95 hover:bg-red-50/50 text-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Transaksi
                </a>
                
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto px-4">
            <div class="receipt-container bg-white p-8 md:p-10 rounded-[2.5rem] text-center shadow-xl">
                
                {{-- ICON SUKSES (DIPERBAGUS) --}}
                <div class="inline-flex p-5 bg-red-soft rounded-full mb-4 border-4 border-red-200 shadow-xl shadow-red-main/20 animate-pulse-once">
                    <svg class="h-10 w-10 text-red-main" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                {{-- TEKS SUKSES (DIPERBAGUS) --}}
                <h2 class="text-4xl font-black mb-1 text-red-main tracking-tighter">TRANSAKSI BERHASIL!</h2>
                <p class="text-gray-600 text-sm mb-8 font-medium">Simpan dan masukkan kode di bawah ke meteran listrik Anda.</p>
                
                {{-- Separator Dashed baru dengan efek sobekan (DIPERBAGUS) --}}
                <div class="mb-8 receipt-top-tear"></div> 

                {{-- BOX TOKEN UTAMA (DIPERBAGUS) --}}
                <div class="bg-white p-6 rounded-3xl border-2 border-red-200/50 mb-8 relative overflow-hidden group shadow-red-soft shadow-xl">
                    <p class="text-[10px] font-extrabold text-gray-500 uppercase tracking-[0.2em] mb-3">Kode Stroom Prabayar</p>
                    <h1 class="text-3xl md:text-3xl font-extrabold font-black text-gray-900 tracking-[0.1em] break-all leading-tight" id="tokenValue">
                        {{ $nomor_token }}
                    </h1>
                    {{-- Tombol Copy --}}
                    <button onclick="copyToken('{{ str_replace('-', '', $nomor_token) }}')" class="mt-4 text-xs font-bold text-red-main hover:text-red-hover transition uppercase tracking-widest flex items-center justify-center gap-2 mx-auto active:scale-[0.98] py-2 px-3 rounded-lg bg-red-50/50 border border-red-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v7a2 2 0 002 2h7m-5-5l5-5m0 0h-5m5 0v5"></path></svg>
                        SALIN KODE TOKEN
                    </button>
                </div>

                {{-- Transaksi: Diperbagus dan diperjelas --}}
                {{-- Detail Transaksi (Diperbagus: Nominal, Biaya Layanan, Waktu, Total) --}}
                <div class="text-left p-6 rounded-2xl border-2 border-red-100 mb-8 shadow-md shadow-gray-100/50 bg-white">
                    
                    {{-- Logika Perhitungan Biaya Layanan dan Total --}}
                    @php
                        $nominal = (int) $amount; // Pastikan $amount adalah integer untuk perbandingan
                        $biaya_layanan = 0;

                        // Logika: Jika nominal = 20000, tambah 500
                        if ($nominal === 20000) {
                            $biaya_layanan = 500;
                        } 
                        // Logika: Jika nominal >= 50000, tambah 1000
                        elseif ($nominal >= 50000) {
                            $biaya_layanan = 1000;
                        }
                        // Untuk nominal selain di atas, biaya layanan diasumsikan 0 atau Anda bisa menetapkan default lain
                        
                        $total_pembayaran = $nominal + $biaya_layanan;
                    @endphp
                    
                    {{-- Header Rincian --}}
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">RINCIAN PEMBAYARAN</p>
                    
                    <div class="pb-3 border-b border-dashed border-gray-200 space-y-3">
                        {{-- Nominal Pembelian --}}
                        <div class="flex justify-between text-sm items-center text-gray-700">
                            <span class="font-medium">Nominal Token:</span>
                            <span class="font-extrabold text-gray-900">Rp{{ number_format($nominal, 0, ',', '.') }}</span>
                        </div>

                        {{-- Biaya Layanan --}}
                        <div class="flex justify-between text-sm items-center text-gray-700">
                            <span class="font-medium">Biaya Layanan:</span>
                            <span class="font-extrabold text-gray-900">Rp{{ number_format($biaya_layanan, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Waktu Transaksi (Dibuat lebih kecil) --}}
                    <div class="flex justify-between text-xs items-center pt-3 text-gray-500">
                        <span class="font-light">Waktu Transaksi:</span>
                        <span class="font-semibold text-gray-600">{{ date('d M Y, H:i') }}</span>
                    </div>

                    {{-- TOTAL (DIBUAT SANGAT BESAR DAN MERAH) --}}
                    <div class="pt-4 mt-4 border-t-2 border-red-main/50 flex justify-between items-center bg-red-50/50 p-3 -mx-3 -mb-3 rounded-b-2xl">
                        <span class="text-xl font-extrabold text-red-main uppercase tracking-tight">TOTAL:</span>
                        <span class="text-3xl font-black text-red-main">
                            Rp{{ number_format($total_pembayaran, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Tombol Aksi: Dibagi 2 Kolom dengan Efek Enchanted --}}
                <div class="grid grid-cols-2 gap-4 print-hidden">
                    {{-- Tombol Cetak/Download Struk (Gaya Soft) --}}
                    <button onclick="window.print()" class="btn-print-style py-4 rounded-2xl font-black text-xs uppercase tracking-widest active:scale-[0.96] shadow-sm flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m0 0v1a2 2 0 002 2h6a2 2 0 002-2v-1M5 12h14M12 9V3"></path></svg>
                        CETAK STRUK
                    </button>
                    {{-- Tombol Selesai (Gaya Utama/Merah) --}}
                    <a href="{{ route('dashboard') }}" class="btn-pay-red py-4 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-red-main/30 hover:shadow-2xl hover:shadow-red-main/50 active:scale-[0.96] flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7m-7 7H21"></path></svg>
                        KEMBALI KE DASHBOARD
                    </a>
                </div>
            </div>
            <p class="mt-8 text-center text-gray-400 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART SMART ENERGY</p>
        </div>
    </div>

    <script>
        function copyToken(text) {
            // Hilangkan semua spasi dan tanda hubung
            const cleanedText = text.replace(/[-\s]/g, ''); 
            navigator.clipboard.writeText(cleanedText);
            
            const button = document.querySelector('button[onclick^="copyToken"]');
            const originalText = button.innerHTML;

            button.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Disalin!';
            
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);
        }
    </script>
</x-app-layout>