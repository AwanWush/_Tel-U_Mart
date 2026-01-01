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

        /* Animasi Hover untuk Kartu Metode Pembayaran */
        .payment-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 **pb-2**">
            {{-- Breadcrumb (Hapus justify-between) --}}
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 md:space-x-3 rtl:space-x-reverse text-sm">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-semibold uppercase tracking-wider text-gray-500 hover:text-red-main transition-colors">
                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 011 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ms-1 text-xs font-extrabold uppercase tracking-wider text-red-main">Beli Galon</span>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- CONTAINER UTAMA: Judul Halaman dan Tombol Riwayat Pesanan (Dibuat sejajar) --}}
            <div class="flex items-center justify-between **mt-4**">
                
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
                        <span class="text-black">GALON</span> <span class="text-red-main">ASRAMA</span>
                    </h1>
                </div>

                {{-- Bagian Kanan: Tombol Riwayat Pesanan --}}
                <a href="{{ route('galon.history') }}"
                    class="btn-history-style inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-white border-2 border-red-main/50 rounded-xl font-bold text-xs sm:text-sm text-red-main uppercase tracking-widest shadow-lg shadow-red-soft active:scale-95 hover:bg-red-50/50 text-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Transaksi
                </a>
            </div>
        </div>
    </x-slot>
    <!-- <div class="py-12 bg-[#F9F9F9] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"
            x-data="{
                galons: @json($galons),
                hasGalon: false,
                pilihanGalon: '',
                hargaSatuan: 0,
                jumlah: 1,
                step: 1,
                metode: 'cod',
                get totalHarga() { return this.hargaSatuan * this.jumlah }
            }"> -->
    {{-- Ganti bg-[#F9F9F9] menjadi bg-gray-50 agar sesuai dengan style token page --}}
    <div class="py-12 min-h-screen bg-gray-50">
        {{-- Pastikan x-data berada di div ini. Ini adalah scope utama Alpine.js. --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" 
            x-data="{ 
                hasGalon: false, 
                pilihanGalon: '',
                hargaSatuan: 0,
                jumlah: 1,
                step: 1,
                metode: 'cod',
                get totalHarga() { return this.hargaSatuan * this.jumlah }
            }">

            {{-- BOX INFORMASI PENGHUNI (Gunakan style baru dari jawaban sebelumnya) --}}
            {{-- ... (Konten Informasi Penghuni - tidak diubah, hanya ditunjukkan konteks) ... --}}
            <div class="bg-white p-8 rounded-[2rem] mb-10 text-gray-800 border-2 border-red-main/10 shadow-xl shadow-red-main/10 transition-all duration-300 hover:shadow-2xl hover:shadow-red-main/15">
                <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                    <div class="p-3 rounded-full mr-4 bg-red-main text-white shadow-lg shadow-red-main/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.935 13.935 0 0112 16c2.585 0 5.013.84 6.942 2.227M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase tracking-wider text-gray-900">Informasi Penghuni Asrama</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="p-4 rounded-xl border-l-4 border-red-main/80 bg-red-soft/50 shadow-md shadow-gray-200/50 transition-all duration-200 hover:bg-red-soft hover:shadow-lg">
                        <div class="flex items-center mb-1">
                            <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest text-red-main">Nama Lengkap</p>
                        </div>
                        <p class="font-extrabold text-gray-900 text-lg ml-6">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="p-4 rounded-xl border-l-4 border-red-main/80 bg-red-soft/50 shadow-md shadow-gray-200/50 transition-all duration-200 hover:bg-red-soft hover:shadow-lg">
                        <div class="flex items-center mb-1">
                            <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m-5 0v-2a2 2 0 012-2h10a2 2 0 012 2v2M7 5h10"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest text-red-main">Gedung Asrama</p>
                        </div>
                        <p class="font-extrabold text-gray-900 text-lg ml-6">{{ Auth::user()->lokasi->nama_lokasi ?? Auth::user()->alamat_gedung ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl border-l-4 border-red-main/80 bg-red-soft/50 shadow-md shadow-gray-200/50 transition-all duration-200 hover:bg-red-soft hover:shadow-lg">
                        <div class="flex items-center mb-1">
                            <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h.01M12 7h.01M16 7h.01M21 12v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3m18-4a2 2 0 00-2-2H5a2 2 0 00-2 2m18 0h.01M19 19H5"></path></svg>
                            <p class="text-xs font-bold uppercase tracking-widest text-red-main">Nomor Kamar</p>
                        </div>
                        <p class="font-extrabold text-gray-900 text-lg ml-6">{{ Auth::user()->nomor_kamar ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- CARD UTAMA PEMESANAN --}}
            <div class="bg-white shadow-xl rounded-[2.5rem] p-10 md:p-14 border border-soft-accent/20">
    
                {{-- STEP 1 --}}
                <div x-show="step === 1" class="space-y-12">
                    <div>
                        {{-- JUDUL DAN GARIS PEMISAH BARU --}}
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full mr-4 bg-red-main text-white shadow-lg shadow-red-main/30">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15.5H9.5a2.5 2.5 0 010-5H11v5zM15 15.5h1.5a2.5 2.5 0 000-5H15v5zM12 2a10 10 0 100 20 10 10 0 000-20zM12 18v2M12 4v2"></path></svg>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                                <span class="text-red-main">Beli</span> Galon
                            </h3>
                        </div>
                        <div class="h-1 w-20 bg-red-main mt-1 ml-16 rounded-full"></div>
                    </div>

                    <div class="space-y-8">
                        <label class="block text-gray-800 font-bold text-xl md:text-2xl tracking-tight">
                            <span class="text-red-main">Langkah 1:</span> Apakah Anda sudah memiliki galon sebelumnya?
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- PILIHAN YA (Isi Ulang) - Styling diubah --}}
                            <label @click="hasGalon = true" class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-md hover:shadow-lg group"
                                :class="hasGalon ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-300 bg-white hover:border-red-main/50'">
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-red-main text-white mr-4 shadow-lg shadow-red-main/30 group-hover:bg-red-hover">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <div>
                                    <span class="font-extrabold text-gray-900 text-xl block">Ya, Isi Ulang</span>
                                    <span class="text-sm text-gray-600 block">Tukar dengan galon kosong</span>
                                </div>
                            </label>

                            {{-- PILIHAN TIDAK (Botol Baru) - Styling diubah --}}
                            <label @click="hasGalon = false; pilihanGalon = ''" class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-md hover:shadow-lg group"
                                :class="!hasGalon ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-300 bg-white hover:border-red-main/50'">
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-200 text-gray-600 mr-4 group-hover:bg-red-main group-hover:text-white transition-colors"
                                    :class="!hasGalon ? 'bg-red-main text-white shadow-lg shadow-red-main/30' : 'bg-gray-200 text-gray-600'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="font-extrabold text-gray-900 text-xl block">Belum Ada, Botol Baru</span>
                                    <span class="text-sm text-gray-600 block">Beli galon baru + isi air</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl border-l-4 border-red-main/50 shadow-inner">
                            <label class="block text-xl font-bold text-gray-800 tracking-tight flex items-center">
                                <svg class="w-6 h-6 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0h10"></path></svg>
                                Pilih Jenis Galon
                            </label>
                            <p class="text-xs text-gray-500 mb-2 ml-8">Pilih sesuai kebutuhan Anda (Isi Ulang/Botol Baru).</p>
                            <select x-model="pilihanGalon"
                                @change="const g = galons.find(x => x.nama === $el.value); hargaSatuan = g ? g.harga : 0"
                                class="form-input-custom focus:ring-red-main focus:border-red-main text-gray-700 font-semibold"
                                required>
                                <option value="" disabled selected class="text-gray-400">-- Pilih Paket Galon --</option>
                                @foreach($galons as $g)
                                    @php $isIsiUlang = str_contains(strtolower($g['nama']), 'isi ulang'); @endphp
                                    <option value="{{ $g['nama'] }}" 
                                            x-show="{{ $isIsiUlang ? 'hasGalon' : 'true' }}"
                                            :disabled="{{ $isIsiUlang ? '!hasGalon' : 'false' }}">
                                        {{ $g['nama'] }} - Rp{{ number_format($g['harga'],0,',','.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl border-l-4 border-red-main/50 shadow-inner">
                            <label class="block text-xl font-bold text-gray-800 tracking-tight flex items-center">
                                <svg class="w-6 h-6 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Jumlah Pesanan
                            </label>
                            <p class="text-xs text-gray-500 mb-2 ml-8">Masukkan jumlah galon yang ingin Anda pesan.</p>
                            <input type="number" x-model.number="jumlah" min="1"
                                class="form-input-custom focus:ring-red-main focus:border-red-main text-gray-700 font-semibold text-center text-2xl"
                                placeholder="Min. 1" required>
                        </div>

                        <div class="space-y-3 md:col-span-2 p-6 bg-red-soft/20 rounded-2xl border-2 border-red-main/30 shadow-md">
                            <label class="block text-xl font-bold text-gray-800 tracking-tight flex items-center">
                                <svg class="w-6 h-6 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Catatan Tambahan (Opsional)
                            </label>
                            <textarea id="catatanInput"
                                class="form-input-custom focus:ring-red-main focus:border-red-main text-gray-700"
                                rows="3"
                                placeholder="Contoh: titip di depan kamar, tolong tukar 2 botol"></textarea>
                            <p class="text-xs text-gray-600 ml-8">Catatan ini akan diteruskan ke petugas pengantar galon.</p>
                        </div>

                    </div>
                    <button type="button" @click="if(pilihanGalon && jumlah >= 1) step = 2"
                        :disabled="!pilihanGalon || jumlah < 1"
                        class="group btn-solid-custom w-full py-5 rounded-xl font-extrabold uppercase tracking-widest text-lg shadow-xl shadow-red-main/30 disabled:opacity-30 disabled:bg-gray-400 disabled:shadow-none">
                        
                        <span class="relative z-10 flex items-center justify-center gap-3 uppercase tracking-wider">
                            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2h-1v1h1c1.657 0 3 .895 3 2s-1.343 2-3 2h-1c-1.657 0-3-.895-3-2s1.343-2 3-2h1v-1h-1c-1.657 0-3-.895-3-2s1.343-2 3-2z"></path></svg>
                            <span>Lanjut ke Pembayaran</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        
                        {{-- Hover Shine Effect --}}
                        <div class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/40 to-transparent z-0"></div>
                    </button>
                </div>

                <!-- {{-- STEP 2 (Metode Pembayaran) --}}
                <div x-show="step === 2" x-cloak class="space-y-10">
                    {{-- Tombol Kembali (Warna merah solid, Tanpa Hover) --}}
                    <button @click="step = 1" class="text-[#930014] text-xs font-black flex items-center cursor-pointer">
                        <i class="fas fa-arrow-left mr-2"></i>
                        KEMBALI KE PEMILIHAN
                    </button> -->
                {{-- STEP 2 (Metode Pembayaran) --}}
                <div x-show="step === 2" x-cloak class="space-y-10">
                    {{-- Tombol Kembali (Diperkecil: w-8 h-8, text-sm, ganti mr-3 jadi mr-2) --}}
                    <a href="javascript:void(0)" @click="step = 1"
                        class="btn-back-style group inline-flex items-center text-gray-500 transition-all duration-300 active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-full border-2 shadow-md flex items-center justify-center mr-2 btn-back-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </div>
                        <span class="font-extrabold text-sm text-gray-900 transition-colors btn-back-text">Kembali ke Pemilihan Galon</span>
                    </a>

                    {{-- GAP DIPERKECIL DI SINI --}}
                    <div class="flex items-center mb-2 mt-[-5rem]"> 
                        <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            <span class="text-red-main">Metode</span> Pembayaran
                        </h3>
                    </div>

                    {{-- GAP DIPERKECIL DENGAN MENGGUNAKAN pt-4 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        {{-- COD Card --}}
                        <div @click="metode = 'cod'" 
                            class="payment-card p-8 rounded-3xl cursor-pointer border-2 transition-all bg-white text-center flex flex-col items-center justify-center group shadow-md hover:shadow-xl hover:border-red-main/50"
                            :class="metode === 'cod' ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-200'">
                            <div class="mb-4 w-16 h-16 flex items-center justify-center rounded-2xl transition-all"
                                :class="metode === 'cod' ? 'bg-red-main text-white shadow-lg shadow-red-main/30' : 'bg-gray-100 text-gray-600 group-hover:bg-red-main group-hover:text-white'">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="font-black text-gray-900 text-2xl">COD</p>
                            <p class="text-sm text-gray-600 mt-1 uppercase tracking-widest font-semibold">Bayar Langsung ke Petugas</p>
                            <p class="text-xs text-gray-400 mt-2 italic">(Hanya tersedia untuk jam operasional)</p>
                        </div>

                        {{-- Midtrans Card --}}
                        <div @click="metode = 'midtrans'" 
                            class="payment-card p-8 rounded-3xl cursor-pointer border-2 transition-all bg-white text-center flex flex-col items-center justify-center group shadow-md hover:shadow-xl hover:border-red-main/50"
                            :class="metode === 'midtrans' ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-200'">
                            <div class="mb-4 w-16 h-16 flex items-center justify-center rounded-2xl transition-all"
                                :class="metode === 'midtrans' ? 'bg-red-main text-white shadow-lg shadow-red-main/30' : 'bg-gray-100 text-gray-600 group-hover:bg-red-main group-hover:text-white'">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.485 0-4.5 2.13-4.5 4.75 0 2.222 1.488 4.25 4.5 4.25s4.5-2.028 4.5-4.25C16.5 10.13 14.485 8 12 8zM12 18V6M7 12H5m14 0h-2"></path></svg>
                            </div>
                            <p class="font-black text-gray-900 text-2xl">MIDTRANS</p>
                            <p class="text-sm text-gray-600 mt-1 uppercase tracking-widest font-semibold">Semua Opsi Pembayaran Online</p>
                            <p class="text-xs text-gray-400 mt-2 italic">(QRIS, Virtual Account, dll.)</p>
                        </div>
                    </div>

                    {{-- PERBAIKAN TOTAL PEMBAYARAN --}}
                    <div class="bg-red-soft/30 p-8 rounded-2xl border-2 border-red-main/50 flex flex-col sm:flex-row justify-between items-center shadow-lg shadow-red-main/10">
                        <div class="text-center sm:text-left mb-4 sm:mb-0">
                            <span class="font-extrabold text-red-main uppercase tracking-widest text-lg block">
                                TOTAL PEMBAYARAN
                            </span>
                            <span class="text-xs text-gray-700 font-semibold italic" x-text="'Rincian: ' + jumlah + 'x ' + pilihanGalon"></span>
                        </div>
                        <span class="font-black text-red-main text-4xl sm:text-5xl" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></span>
                    </div>

                    {{-- TOMBOL FINAL ORDER --}}
                    <button id="btnFinalOrder" @click="handleOrder($data)"
                        class="group btn-solid-custom w-full py-5 rounded-xl font-extrabold uppercase tracking-widest text-lg shadow-xl shadow-red-main/30 disabled:opacity-30 disabled:bg-gray-400 disabled:shadow-none">
                        
                        <span class="relative z-10 flex items-center justify-center gap-3 uppercase tracking-wider">
                            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.003 12.003 0 0012 21.011a12.003 12.003 0 008.618-14.015z"></path></svg>
                            <span x-text="metode === 'cod' ? 'Konfirmasi & Pesan (Bayar di Tempat)' : 'Bayar Sekarang (Online Payment)'"></span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        
                        {{-- Hover Shine Effect - DIGANTI menggunakan shimmer-effect class --}}
                        <div class="shimmer-effect"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Form untuk COD --}}
    <form id="realForm" action="{{ route('galon.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="nama_galon">
        <input type="hidden" name="jumlah">
        <input type="hidden" name="catatan">
        <input type="hidden" name="harga_satuan">
        <input type="hidden" name="metode_pembayaran" value="COD">
    </form>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
        const galons = @json($galons);

        async function handleOrder(alpineData) {
            const btn = document.getElementById('btnFinalOrder');
            const catatanValue = document.getElementById('catatanInput').value;

            if (alpineData.metode === 'cod') {
                // LOGIKA COD
                const form = document.getElementById('realForm');
                form.querySelector('[name=nama_galon]').value = alpineData.pilihanGalon;
                form.querySelector('[name=jumlah]').value = alpineData.jumlah;
                form.querySelector('[name=catatan]').value = catatanValue;
                form.querySelector('[name=harga_satuan]').value = alpineData.hargaSatuan;
                form.submit();
            } else {
                // LOGIKA MIDTRANS
                btn.disabled = true;
                btn.innerText = 'MEMPROSES...';
                
                try {
                    const response = await fetch("{{ route('payment.snap-galon') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            total_amount: alpineData.totalHarga,
                            product_name: alpineData.pilihanGalon
                        })
                    });

                    const midData = await response.json();

                    if (!midData.snap_token) {
                        alert('Gagal mendapatkan token pembayaran. Silakan coba lagi.');
                        btn.disabled = false;
                        btn.innerText = 'Buat Pesanan Sekarang';
                        return;
                    }

                    window.snap.pay(midData.snap_token, {
                        onSuccess: async function(result) {
                            try {
                                const save = await fetch("{{ route('galon.store.midtrans') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        nama_galon: alpineData.pilihanGalon,
                                        jumlah: alpineData.jumlah,
                                        harga_satuan: alpineData.hargaSatuan,
                                        total_harga: alpineData.totalHarga,
                                        order_id: result.order_id,
                                        status: 'paid'
                                    })
                                });

                                if (!save.ok) throw new Error('Gagal simpan transaksi');

                                const res = await save.json();

                                window.location.href = `/fitur-user/galon-result/${res.id}`;

                            } catch (err) {
                                // alert('Pembayaran berhasil, tapi gagal menyimpan transaksi.');
                                alert(`Terjadi error: ${err.message}`); console.log('Detail error:', err); console.log('Stack trace:', err.stack);
                                btn.disabled = false;
                                btn.innerText = 'Buat Pesanan Sekarang';
                            }
                        },
                        onPending: async function(result) {
                            try {
                                const save = await fetch("{{ route('galon.store.midtrans') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        nama_galon: alpineData.pilihanGalon,
                                        jumlah: alpineData.jumlah,
                                        harga_satuan: alpineData.hargaSatuan,
                                        total_harga: alpineData.totalHarga,
                                        order_id: result.order_id,
                                        status: 'pending'
                                    })
                                });

                                const res = await save.json();
                                window.location.href = `/fitur-user/galon-pending/${res.id}`;
                            } catch {
                                alert('Pesanan pending, tapi gagal disimpan.');
                            }
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal atau dibatalkan oleh sistem.');
                            btn.disabled = false;
                            btn.innerText = 'Buat Pesanan Sekarang';
                        },
                        onClose: function() {
                            alert('Pembayaran belum selesai.');
                            btn.disabled = false;
                            btn.innerText = 'Buat Pesanan Sekarang';
                        }
                    });
                } catch (e) {
                    alert('Gagal memproses pembayaran online.');
                    btn.disabled = false;
                    btn.innerText = 'Buat Pesanan Sekarang';
                }
            }
        }
    </script>
</x-app-layout>