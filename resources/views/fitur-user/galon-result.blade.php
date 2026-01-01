<x-app-layout>
    <style>
        /* Tambahkan style dasar dari token page */
        .bg-red-main { background-color: #dc2626; }
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        .hover\:bg-red-hover:hover { background-color: #b91c1c; }
        .shadow-red-soft { box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); }
        .text-red-soft-darker { color: #fecaca; }
        .bg-red-soft { background-color: #fee2e2; }

        /* Tambahkan keyframe untuk animasi shimmer */
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        /* Tambahkan style untuk animasi sederhana pada ikon check */
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.5s ease-out;
        }

        /* Tombol Solid (Lanjut & Konfirmasi) - DISESUAIKAN DARI btn-pay-red */
        .btn-solid-custom {
            /* ... (Style yang sudah ada) ... */
            background-color: #dc2626 !important; /* bg-red-main */
            color: #ffffff !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateZ(0);
            position: relative; /* Wajib ada */
            overflow: hidden; /* Wajib ada */
        }
        /* ... (Style btn-solid-custom:hover lainnya) ... */

        /* --- TAMBAHAN: Class untuk shimmer effect di tombol konfirmasi/lanjut --- */
        .shimmer-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.4) 50%, 
                rgba(255, 255, 255, 0) 100%);
            transform: translateX(-100%); /* Mulai dari luar kiri */
        }
        .btn-solid-custom:hover .shimmer-effect {
            animation: shimmer 1.5s infinite;
        }
        .btn-solid-custom:hover {
            /* ... (Style yang sudah ada) ... */
            background-color: #b91c1c !important; /* hover:bg-red-hover */
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4) !important;
            transform: translateY(-2px) !important;
        }

        /* Tambahkan class baru untuk styling kontainer detail */
        .detail-row-container {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .detail-row-container:hover {
            background-color: #fefcfb !important; /* Slightly lighter on hover */
            transform: translateY(-2px); /* Slight lift */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        /* Tombol Outline (Riwayat) - DISESUAIKAN DARI btn-history-style */
        .btn-outline-custom {
            background-color: white !important;
            color: #dc2626 !important; /* text-red-main */
            border: 2px solid #dc2626 !important; /* border-red-main */
            transition: all 0.3s ease;
            transform: translateZ(0);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); /* shadow-red-soft */
        }
        .btn-outline-custom:hover {
            background-color: #dc2626 !important; /* bg-red-main */
            color: white !important;
            border-color: #dc2626 !important;
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3) !important;
            transform: translateY(-2px) !important;
        }

        /* Styling khusus untuk tombol Riwayat Transaksi */
        .btn-history-style {
            transition: all 0.3s ease;
            transform: translateZ(0); /* Force hardware acceleration */
        }
        .btn-history-style:hover {
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
            border-color: #dc2626;
            transform: translateY(-2px);
        }

        .btn-outline-custom-reverse {
            background-color: #DB4B3A !important; /* Primary Accent */
            color: #ffffff !important;
            border: 2px solid #930014 !important; /* Deep Accent */
            transition: all 0.3s ease;
            transform: translateZ(0);
            box-shadow: 0 4px 12px rgba(219, 75, 58, 0.3);
        }
        .btn-outline-custom-reverse:hover {
            background-color: #930014 !important; /* Deep Accent */
            color: white !important;
            border-color: #5B000B !important; /* Dark Accent */
            box-shadow: 0 6px 15px rgba(147, 0, 20, 0.5) !important;
            transform: translateY(-2px) !important;
        }

        /* Tombol Solid Accent (Deep Accent) */
        .btn-solid-accent {
            background-color: #930014 !important; /* Deep Accent */
            color: #ffffff !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(147, 0, 20, 0.3);
        }
        .btn-solid-accent:hover {
            background-color: #5B000B !important; /* Dark Accent */
            box-shadow: 0 10px 20px rgba(91, 0, 11, 0.5) !important;
            transform: translateY(-2px) !important;
        }

        /* Form Input - Diselaraskan dengan gaya Token Page */
        .form-input-custom {
            border: 1px solid #E5E7EB !important; /* border-gray-200 */
            border-radius: 0.75rem !important;
            padding: 1rem !important;
            width: 100%;
            background-color: white !important;
            transition: all 0.3s ease;
        }
        .form-input-custom:focus {
            border-color: #dc2626 !important; /* focus:border-red-main */
            ring-color: #dc2626 !important; /* focus:ring-red-main */
        }
        
        /* Tombol Kembali (Back Button) Styling dari Token Page */
        .btn-back-style {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
        }
        .btn-back-icon {
            background-color: #fef2f2; /* bg-red-50 */
            border-color: #fca5a5; /* border-red-300 */
            color: #dc2626; /* text-red-main */
            transition: all 0.3s ease-in-out;
            /* PERUBAHAN UKURAN IKON */
            width: 8; /* w-8 */
            height: 8; /* h-8 */
            padding: 0.3rem; /* p-1.5, memperkecil padding */
            font-size: 0.875rem; /* text-sm, memperkecil ukuran ikon di dalamnya */
        }
        .btn-back-style:hover .btn-back-icon {
            background-color: #dc2626; /* bg-red-main */
            border-color: #b91c1c; /* border-red-800 */
            color: white;
            transform: scale(1.1);
        }
        .btn-back-style:hover .btn-back-text {
            color: #b91c1c; /* text-red-hover */
            transform: translateX(4px);
        }
        
        /* --- STYLE BARU UNTUK BACK BUTTON PADA JUDUL HEADER (Hanya Ikon) --- */
        .btn-back-icon-only {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent; /* Tambahkan border transparan */
            color: #dc2626; /* text-red-main */
        }
        .btn-back-icon-only:hover {
            color: #b91c1c; /* text-red-hover */
            transform: translateX(-3px); /* Sedikit efek bergerak ke kiri */
        }
    </style>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-2">
            {{-- Breadcrumb --}}
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse text-sm">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-red-main transition-colors">
                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('galon.index') }}" class="ms-1 text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-red-main transition-colors">Beli Galon</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-red-main">Pesanan Berhasil</span>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- CONTAINER UTAMA: Judul Halaman dan Tombol Riwayat Pesanan (Dibuat sejajar) --}}
            <div class="flex items-center justify-between mt-4">
                
                {{-- Bagian Kiri: Tombol Kembali (Ikon) dan Judul Halaman --}}
                <div class="flex items-center">
                    {{-- Tombol Kembali ke Galon Page (Hanya Ikon) --}}
                    <a href="{{ route('galon.index') }}"
                        {{-- **TIDAK PERLU DIUBAH:** Sudah menggunakan class `btn-back-icon-only` dan `hover:text-red-main` --}}
                        class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-red-main active:scale-[0.98]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    
                    {{-- Judul Halaman --}}
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                        {{-- **PERUBAHAN:** Samakan dengan "GALON ASRAMA" di galon page --}}
                        <span class="text-black">GALON</span> <span class="text-red-main">RESULT</span>
                    </h1>
                </div>

                {{-- Bagian Kanan: Tombol Riwayat Pesanan (Menyesuaikan dengan galon page) --}}
                <a href="{{ route('galon.history') }}"
                    {{-- **PERUBAHAN:** Ganti class dan color untuk menyamakan dengan galon page.
                        Di `galon page` menggunakan: `border-2 border-red-main/50`, `text-red-main`, `shadow-lg shadow-red-soft`, `hover:bg-red-50/50`.
                        Di `galon result` saat ini: `border-2 border-red-main/50`, `text-red-main`, `shadow-lg shadow-red-soft`, `hover:bg-red-50/50`.
                        TIDAK ADA PERUBAHAN PADA CLASS, hanya memastikan sama. --}}
                    class="btn-history-style inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-white border-2 border-red-main/50 rounded-xl font-bold text-xs sm:text-sm text-red-main uppercase tracking-widest shadow-lg shadow-red-soft active:scale-95 hover:bg-red-50/50 text-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Transaksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- KONTEN UTAMA: Card Hasil Pesanan --}}
            <div class="bg-white shadow-xl rounded-[2.5rem] p-8 sm:p-10 border-2 border-red-main/10">

                {{-- HEADER RESULT CARD --}}
                <div class="text-center mb-10">
                    {{-- Ikon Check Ditingkatkan (menggunakan Primary Accent dan animasi) --}}
                    <div class="w-20 h-20 bg-[#DB4B3A]/10 text-[#DB4B3A] rounded-full flex items-center justify-center mx-auto mb-4 animate-fade-in-up">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    
                    {{-- Judul dan Subtitle Baru --}}
                    <h3 class="text-3xl font-black text-[#5B000B] tracking-tight"> {{-- Dark Accent --}}
                        <span class="text-[#DB4B3A]">PESANAN</span> BERHASIL!
                    </h3>
                    <p class="text-gray-500 text-sm mt-2 max-w-sm mx-auto">
                        Terima kasih, pesanan Anda telah berhasil diterima dan sedang disiapkan.
                    </p>
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Ringkasan Pesanan</h4>

                    {{-- DETAIL PESANAN --}}
                    <div class="space-y-3">
                        
                        {{-- ROW 1: Jenis Pesanan --}}
                        <div class="detail-row-container items-center p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Jenis Pesanan</p>
                            <p class="text-sm font-bold text-gray-900">{{ $transaksi->nama_galon }}</p>
                        </div>

                        {{-- ROW 2: Jumlah & Harga Satuan (Grid) --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="detail-row-container p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Jumlah</p>
                                <p class="text-sm font-bold text-gray-900">{{ $transaksi->jumlah }} Galon</p>
                            </div>
                            <div class="detail-row-container p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Harga Satuan</p>
                                <p class="text-sm font-bold text-gray-900">
                                    Rp{{ number_format($transaksi->harga_satuan, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- ROW 3: Waktu Transaksi & Status --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="detail-row-container p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Waktu Transaksi</p>
                                <p class="text-sm font-bold text-gray-900">{{ $transaksi->waktu_transaksi }}</p>
                            </div>
                            <div class="detail-row-container p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white shadow-md
                                    @if($transaksi->status === 'pending') bg-[#E68757] shadow-[#E68757]/30 {{-- Secondary Accent --}}
                                    @elseif($transaksi->status === 'diproses') bg-[#DB4B3A] shadow-[#DB4B3A]/30 {{-- Primary Accent --}}
                                    @elseif($transaksi->status === 'paid') bg-green-600 shadow-green-600/30
                                    @else bg-gray-400 shadow-gray-400/30 @endif">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- ROW 4 : TOTAL & ACTION --}}
                    <div class="mt-6 p-6 rounded-2xl bg-[#fee2e2] border-2 border-red-soft shadow-lg shadow-red-soft/50">
                        <div class="flex justify-between items-center mb-5">
                            <p class="text-sm font-bold uppercase tracking-wider text-[#DB4B3A]">
                                Total Pembayaran
                            </p>
                            <p class="text-3xl font-black text-[#930014]">
                                Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-red-soft/80">
                            {{-- Button 1 (Primary: Kembali ke Dashboard) --}}
                            <a href="{{ route('dashboard') }}"
                            class="px-4 py-3 btn-solid-accent text-white rounded-xl text-center text-sm font-bold uppercase tracking-widest active:scale-95">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                            
                            {{-- Button 2 (Secondary: Pesan Lagi) --}}
                            <a href="{{ route('galon.index') }}"
                            class="px-4 py-3 bg-white border-2 border-[#DB4B3A] text-[#DB4B3A] rounded-xl text-center text-sm font-bold uppercase tracking-widest active:scale-95 hover:bg-[#DB4B3A] hover:text-white transition-all shadow-md">
                                <i class="fas fa-plus-circle mr-2"></i> Pesan Lagi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>