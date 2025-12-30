<x-app-layout>
    {{-- Custom Stylesheet untuk Palet Warna dan Animasi Tambahan --}}
    <style>
        .bg-primary-accent { background-color: #DB4B3A; }
        .text-primary-accent { color: #DB4B3A; }
        .border-primary-accent { border-color: #DB4B3A; }
        
        /* WARNA UTAMA */
        .bg-red-main { background-color: #dc2626; }
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        
        .hover\:bg-red-hover:hover { background-color: #b91c1c; }
        /* Mengubah shadow-red-soft agar lebih soft/sesuai tombol */
        .shadow-red-soft { box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); }
        .text-dark-accent { color: #5B000B; }
        .text-soft-accent { color: #E7BD8A; }
        .text-secondary { color: #E68757; }
        .bg-red-soft { background-color: #fee2e2; }
        .text-red-soft-darker { color: #fecaca; }
        .border-soft-accent { border-color: #E7BD8A; }

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

        /* Keyframes untuk efek shimmer pada tombol bayar */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .group-hover\:animate-\[shimmer_1\.5s_infinite\]:hover {
            animation: shimmer 1.5s infinite;
        }

        /* Hidden Radio Input */
        .token-card-radio:checked + .token-card {
            border-color: #dc2626; /* border-red-main */
            background-color: #fef2f2; /* bg-red-50 */
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.1), 0 4px 6px -2px rgba(220, 38, 38, 0.05); /* shadow-md/red */
            transform: translateY(-2px);
        }
        .token-card {
            transition: all 0.3s ease;
        }

        /* === BARU DITAMBAHKAN/DIUBAH UNTUK TOMBOL BAYAR MERAH TERBARU === */
        .btn-pay-red {
            background-color: #dc2626; /* bg-red-main */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
        }
        .btn-pay-red:hover {
            background-color: #b91c1c; /* hover:bg-red-hover */
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4); /* Shadow lebih kuat saat hover */
            transform: translateY(-2px);
        }

        /* Custom Styling untuk Struk */
        .receipt-container {
            /* Warna latar belakang struk */
            background-color: #ffffff; 
            /* Sedikit shadow untuk mengangkat */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
            /* Gunakan border radius yang lebih lembut */
            border-radius: 1.5rem;
        }

        .receipt-top-tear {
            /* Efek sobekan kertas atas (gunakan pseudo-element untuk detail lebih lanjut) */
            border-top: 3px dashed #e5e7eb;
            position: relative;
            margin: 1.5rem 0;
        }
        
        .receipt-top-tear::before, .receipt-top-tear::after {
            content: '';
            position: absolute;
            top: -10px; /* Setengah dari tinggi/lebar agar pas di garis */
            width: 20px;
            height: 20px;
            background-color: #f9fafb; /* Sesuaikan dengan bg outer div */
            border: 2px solid #e5e7eb;
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

        /* === Modifikasi untuk Tombol Kembali (Back Button) */
        .btn-back-style {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
            /* Warna default: Hitam untuk teks, merah border/hover */
        }
        .btn-back-icon {
            background-color: #fef2f2; /* bg-red-50 */
            border-color: #fca5a5; /* border-red-300 */
            color: #dc2626; /* text-red-main */
            transition: all 0.3s ease-in-out;
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

        /* === BARU DITAMBAHKAN DARI GALON PAGE UNTUK HEADER STYLE === */
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
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-red-main">Beli Token</span>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- CONTAINER UTAMA: Judul Halaman dan Tombol Riwayat Transaksi --}}
            <div class="flex items-center justify-between mt-4">
                
                {{-- Bagian Kiri: Tombol Kembali (Ikon) dan Judul Halaman --}}
                <div class="flex items-center">
                    {{-- Tombol Kembali ke Beranda (Hanya Ikon) --}}
                    <a href="{{ route('dashboard') }}"
                        class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-red-main active:scale-[0.98]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    
                    {{-- Judul Halaman --}}
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                        <span class="text-red-main">TOKEN</span> <span class="text-black">LISTRIK</span>
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

    {{-- Background Utama: Putih Bersih --}}
    <div class="py-12 min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ 
                 nominal: '', 
                 harga: 0, 
                 updateHarga(nominalValue, hargaValue) {
                     this.nominal = nominalValue;
                     this.harga = hargaValue;
                 },
                 currency(amount) {
                     return 'Rp' + amount.toLocaleString('id-ID');
                 }
             }"
             x-init="
                 // Inisialisasi: Pilih opsi pertama jika ada (opsional)
                 // const firstToken = {{ count($tokens) > 0 ? json_encode($tokens[0]) : 'null' }};
                 // if (firstToken) { updateHarga(firstToken.nominal, firstToken.harga); }
             ">

            {{-- Card Informasi Pengguna (DIPERBAGUS) --}}
            <div class="bg-white p-8 rounded-[2rem] mb-10 text-gray-800 border-2 border-red-main/10 shadow-xl shadow-red-main/10 transition-all duration-300 hover:shadow-2xl hover:shadow-red-main/15">
                <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                    {{-- Icon Profil Lebih Menarik --}}
                    <div class="p-3 rounded-full mr-4 bg-red-main text-white shadow-lg shadow-red-main/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.935 13.935 0 0112 16c2.585 0 5.013.84 6.942 2.227M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase tracking-wider text-gray-900">Informasi Penghuni Asrama</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    {{-- Detail 1: Nama Lengkap (Diberi Shadow) --}}
                    <div class="p-4 rounded-xl border-l-4 border-red-main/80 bg-red-soft/50 shadow-md shadow-gray-200/50 transition-all duration-200 hover:bg-red-soft hover:shadow-lg">
                        <div class="flex items-center mb-1">
                            <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest text-red-main">Nama Lengkap</p>
                        </div>
                        <p class="font-extrabold text-gray-900 text-lg ml-6">{{ Auth::user()->name }}</p>
                    </div>
                        
                    {{-- Detail 2: Gedung Asrama (Diberi Shadow) --}}
                    <div class="p-4 rounded-xl border-l-4 border-red-main/80 bg-red-soft/50 shadow-md shadow-gray-200/50 transition-all duration-200 hover:bg-red-soft hover:shadow-lg">
                        <div class="flex items-center mb-1">
                            <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m-5 0v-2a2 2 0 012-2h10a2 2 0 012 2v2M7 5h10"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest text-red-main">Gedung Asrama</p>
                        </div>
                        <p class="font-extrabold text-gray-900 text-lg ml-6">{{ Auth::user()->lokasi->nama_lokasi ?? Auth::user()->alamat_gedung ?? '-' }}</p>
                    </div>
                        
                    {{-- Detail 3: Nomor Kamar (Diberi Shadow) --}}
                    <div class="p-4 rounded-xl border-l-4 border-red-main/80 bg-red-soft/50 shadow-md shadow-gray-200/50 transition-all duration-200 hover:bg-red-soft hover:shadow-lg">
                        <div class="flex items-center mb-1">
                            <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h.01M12 7h.01M16 7h.01M21 12v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3m18-4a2 2 0 00-2-2H5a2 2 0 00-2 2m18 0h.01M19 19H5"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest text-red-main">Nomor Kamar</p>
                        </div>
                        <p class="font-extrabold text-gray-900 text-lg ml-6">{{ Auth::user()->nomor_kamar ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Card Form Pembelian --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl text-gray-800 relative overflow-hidden ring-1 ring-gray-100">
                
                {{-- Decorative Background Elements --}}
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full blur-3xl opacity-20 bg-red-main pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full blur-3xl opacity-20 bg-orange-300 pointer-events-none"></div>

                <div class="p-8 md:p-12 relative z-10">
                    <div class="flex flex-col md:flex-row gap-12">
                        
                        {{-- KOLOM KIRI: INPUT --}}
                        <div class="w-full md:w-1/2 space-y-8">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight flex items-center mb-2">
                                    <span class="bg-red-main text-white p-2 rounded-lg mr-3 shadow-lg shadow-red-main/30">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </span>
                                    Beli Token
                                </h3>
                                <p class="text-gray-500 text-sm font-medium ml-[3.25rem]">Pilih paket listrik sesuai kebutuhanmu.</p>
                            </div>

                            {{-- START: PERBAIKAN PILIHAN PAKET --}}
                            <div class="space-y-4">
                                <h4 class="block text-xs font-bold uppercase tracking-widest text-gray-400">Pilihan Paket Nominal (Rupiah)</h4>
                                
                                <form id="tokenForm" method="POST" action="javascript:void(0)"> 
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach ($tokens as $t)
                                        <label for="nominal_{{ $t['nominal'] }}" class="cursor-pointer">
                                            {{-- Hidden Radio Input --}}
                                            <input type="radio" 
                                                   name="nominal_token" 
                                                   id="nominal_{{ $t['nominal'] }}" 
                                                   value="{{ $t['nominal'] }}" 
                                                   data-harga="{{ $t['harga'] }}"
                                                   @change="updateHarga({{ $t['nominal'] }}, {{ $t['harga'] }})"
                                                   class="sr-only token-card-radio">

                                            {{-- Custom Card for Radio Button --}}
                                            <div class="token-card p-5 rounded-2xl border-2 border-gray-200 bg-white transition-all duration-300 hover:border-red-main/50 hover:shadow-md hover:shadow-red-main/10 active:scale-[0.98]">
                                                <p class="text-sm font-black uppercase tracking-wider mb-1 text-gray-400">Nominal</p>
                                                <h5 class="text-xl font-extrabold text-red-main tracking-tight">
                                                    Rp{{ number_format($t['nominal'], 0, ',', '.') }}
                                                </h5>
                                                <p class="text-xs font-medium text-gray-500 mt-2">
                                                    Total Bayar: <span class="font-bold text-gray-800" x-text="currency({{ $t['harga'] }})">Rp{{ number_format($t['harga'], 0, ',', '.') }}</span>
                                                </p>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>

                                    {{-- Hidden field untuk kirim data ke script JS --}}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>

                            </div>
                            {{-- END: PERBAIKAN PILIHAN PAKET --}}

                            {{-- Info Box --}}
                            <div class="bg-red-soft border border-red-200 rounded-2xl p-4 flex items-start gap-4">
                                <div class="bg-red-100 text-red-main rounded-full p-2 mt-1 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 text-red-main">Transaksi Instan</h5>
                                    <p class="text-xs text-gray-500 leading-relaxed mt-1">
                                        Token akan muncul otomatis di halaman <b>Riwayat Transaksi</b> setelah pembayaran berhasil diverifikasi.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: RINGKASAN (Style Struk) --}}
                        <div class="w-full md:w-1/2">
                            {{-- Menggunakan class custom: receipt-container dan receipt-content-bg --}}
                            <div class="receipt-container h-full receipt-content-bg rounded-[2rem] border border-gray-200 relative flex flex-col justify-between overflow-hidden">
                                
                                <div class="p-8 pb-4 relative z-10">
                                    {{-- HEADER STRUK --}}
                                    <div class="text-center mb-6">
                                        <h4 class="text-xl font-extrabold text-red-main uppercase tracking-widest">TJ-T MART</h4>
                                        <p class="text-xs text-gray-500 mt-1">Struk Pembelian Token Listrik</p>
                                        <p class="text-[10px] text-gray-400 mt-2 border-t border-b border-dashed border-gray-300 py-1 inline-block px-3">
                                            ID Transaksi: XXXX-{{ substr(Auth::user()->id, -4) }} | Tgl: {{ date('d/m/Y') }}
                                        </p>
                                    </div>

                                    {{-- ITEM LIST & RINCIAN --}}
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center mb-6">
                                            <h4 class="font-black text-xs uppercase tracking-[0.2em] text-gray-400">Rincian Order</h4>
                                            <div class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">
                                                STATUS: READY
                                            </div>
                                        </div>

                                        {{-- Item List --}}
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center group border-b border-dashed border-gray-200 pb-2">
                                                <span class="text-sm font-medium text-gray-600">Nama Pelanggan</span>
                                                <span class="text-base font-bold text-gray-800">{{ Auth::user()->name }}</span>
                                            </div>
                                            <div class="flex justify-between items-center group border-b border-dashed border-gray-200 pb-2">
                                                <span class="text-sm font-medium text-gray-600">Nominal Token</span>
                                                <span class="text-base font-bold text-gray-800" x-text="nominal ? currency(parseInt(nominal)) : 'Rp0'">Rp0</span>
                                            </div>
                                            <div class="flex justify-between items-center group border-b border-dashed border-gray-200 pb-2">
                                                <span class="text-sm font-medium text-gray-600">Biaya Layanan</span>
                                                <span class="text-base font-bold text-gray-800" x-text="harga && nominal ? currency(harga - nominal) : 'Rp0'">Rp0</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Separator Dashed baru dengan efek sobekan --}}
                                    <div class="my-8 receipt-top-tear"></div> 

                                    {{-- Total Section --}}
                                    <div class="flex flex-col gap-2">
                                        <span class="text-sm font-bold text-gray-500 uppercase tracking-widest text-center">TOTAL HARGA</span>
                                        <div class="flex items-baseline justify-center gap-1">
                                            <span class="text-5xl font-black text-red-main tracking-tight" x-text="harga ? currency(parseInt(harga)) : 'Rp0'">Rp0</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- FOOTER STRUK & Tombol Bayar --}}
                                <div class="p-8 pt-0 mt-auto bg-white/50 backdrop-blur-sm border-t border-gray-100">
                                    <div class="mt-4">
                                        <button id="payBtn"
                                            class="group w-full relative overflow-hidden btn-pay-red text-white font-black text-lg py-4 rounded-xl shadow-xl shadow-red-main/30 disabled:opacity-50 disabled:bg-gray-400 disabled:shadow-none"
                                            :disabled="!nominal"
                                            onclick="initiatePayment()">
                                            
                                            <span class="relative z-10 flex items-center justify-center gap-3 uppercase tracking-wider">
                                                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2h-1v1h1c1.657 0 3 .895 3 2s-1.343 2-3 2h-1c-1.657 0-3-.895-3-2s1.343-2 3-2h1v-1h-1c-1.657 0-3-.895-3-2s1.343-2 3-2z"></path></svg>
                                                <span>BAYAR SEKARANG</span>
                                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </span>
                                            
                                            {{-- Hover Shine Effect --}}
                                            <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/40 to-transparent z-0"></div>
                                        </button>
                                        
                                        <div class="mt-4 flex items-center justify-center gap-2 opacity-60">
                                            <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/></svg>
                                            <span class="text-[10px] uppercase text-gray-400 font-bold tracking-widest">Secure Payment by Midtrans</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="mt-8 text-center text-gray-400 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART SMART ENERGY</p>
        </div>
    </div>

    {{-- SCRIPT MIDTRANS --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script>
        function initiatePayment() {
            const selectedRadio = document.querySelector('input[name="nominal_token"]:checked');
            
            if (!selectedRadio) {
                alert('Pilih nominal token terlebih dahulu.');
                return;
            }

            const nominal = selectedRadio.value;
            const harga = selectedRadio.getAttribute('data-harga');
            
            const btn = document.getElementById('payBtn');
            // ... di dalam function initiatePayment()
            btn.disabled = true;
            // Menggunakan kelas text-white dari tombol utama, dan menambahkan spinner sederhana
            btn.innerHTML = '<span class="relative z-10 flex items-center justify-center gap-3 uppercase tracking-wider"><svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 0020 12c0-4.418-3.582-8-8-8z"></path></svg><span>Memproses...</span></span>'; 

            processPayment(nominal, harga, btn);
        }

        async function processPayment(nominal, harga, btn) {
            try {
                const response = await fetch("{{ route('payment.snap-token') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        total_amount: harga,
                        type: 'token',
                        nominal: nominal
                    })
                });

                const data = await response.json();

                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: async function (result) {
                            const response = await fetch('/token-listrik/beli', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    nominal: nominal,
                                    harga: harga,
                                    metode: result.payment_type,
                                    order_id: result.order_id
                                })
                            });

                            const data = await response.json();

                            window.location.href = `/token/result/${data.id}`;
                        },
                        onPending: function () {
                            alert('Pembayaran pending, silakan selesaikan pembayaran.');
                        },
                        onError: function () {
                            alert('Pembayaran gagal.');
                        },
                        onClose: function () {
                            btn.disabled = false;
                        }
                    });
                } else {
                    alert('Gagal mendapatkan token pembayaran: ' + (data.message || 'Unknown error'));
                    btn.disabled = false;
                    btn.innerHTML = '<span class="relative z-10 flex items-center justify-center gap-3"><span>BAYAR SEKARANG</span><svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>';
                }

            } catch (e) {
                alert('Gagal menghubungi server pembayaran.');
                btn.disabled = false;
                btn.innerHTML = '<span class="relative z-10 flex items-center justify-center gap-3"><span>BAYAR SEKARANG</span><svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></span>';
            }
        };
    </script>
</x-app-layout>