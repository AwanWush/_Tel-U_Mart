<x-app-layout>
    <style>
        .bg-red-main { background-color: #dc2626; }
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        .hover\:bg-red-hover:hover { background-color: #b91c1c; }
        .shadow-red-soft { box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); }
        .text-red-soft-darker { color: #fecaca; }
        .bg-red-soft { background-color: #fee2e2; }

        [x-cloak] { display: none !important; }

        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }

        .btn-solid-custom {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateZ(0);
            position: relative;
            overflow: hidden;
        }
        .shimmer-effect {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            transform: translateX(-100%);
        }
        .btn-solid-custom:hover .shimmer-effect {
            animation: shimmer 1.5s infinite;
        }
        .btn-solid-custom:hover {
            background-color: #b91c1c !important;
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4) !important;
            transform: translateY(-2px) !important;
        }

        .btn-history-style {
            transition: all 0.3s ease;
            transform: translateZ(0);
        }
        .btn-history-style:hover {
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
            border-color: #dc2626;
            transform: translateY(-2px);
        }

        .payment-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .form-input-custom {
            border: 1px solid #E5E7EB !important;
            border-radius: 0.75rem !important;
            padding: 1rem !important;
            width: 100%;
            background-color: white !important;
            transition: all 0.3s ease;
        }
        .form-input-custom:focus {
            border-color: #dc2626 !important;
        }

        .btn-back-style {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
        }
        .btn-back-icon {
            background-color: #fef2f2;
            border-color: #fca5a5;
            color: #dc2626;
            transition: all 0.3s ease-in-out;
        }
        .btn-back-style:hover .btn-back-icon {
            background-color: #dc2626;
            border-color: #b91c1c;
            color: white;
            transform: scale(1.1);
        }
        .btn-back-style:hover .btn-back-text {
            color: #b91c1c;
            transform: translateX(4px);
        }

        .btn-back-icon-only {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            color: #dc2626;
        }
        .btn-back-icon-only:hover {
            color: #b91c1c;
            transform: translateX(-3px);
        }
    </style>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-2">
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
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="btn-back-icon-only p-2 rounded-full mr-1 -ml-1 text-gray-500 hover:text-red-main active:scale-[0.98]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                        <span class="text-black">GALON</span> <span class="text-red-main">ASRAMA</span>
                    </h1>
                </div>
                <a href="{{ route('galon.history') }}"
                    class="btn-history-style inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-white border-2 border-red-main/50 rounded-xl font-bold text-xs sm:text-sm text-red-main uppercase tracking-widest shadow-lg shadow-red-soft active:scale-95 hover:bg-red-50/50 text-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Transaksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"
            x-data="{
                hasGalon: false,
                pilihanGalon: '',
                hargaSatuan: 0,
                jumlah: 1,
                step: 1,
                metode: 'cod',
                pengiriman: 'ambil',
                ongkir: 3000,
                get totalHarga() {
                    let base = this.hargaSatuan * this.jumlah;
                    return this.pengiriman === 'antar' ? base + (this.ongkir * this.jumlah) : base;
                }
            }">

            {{-- BOX INFORMASI PENGHUNI --}}
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
            <div class="bg-white shadow-xl rounded-[2.5rem] p-10 md:p-14 border border-gray-100">

                {{-- ============================== --}}
                {{-- STEP 1 - MULAI --}}
                {{-- ============================== --}}
                <div x-show="step === 1" x-cloak class="space-y-8">

                    {{-- Judul --}}
                    <div>
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

                    {{-- Langkah 1: Punya galon? --}}
                    <div class="space-y-4">
                        <label class="block text-gray-800 font-bold text-xl md:text-2xl tracking-tight">
                            <span class="text-red-main">Langkah 1:</span> Apakah Anda sudah memiliki galon sebelumnya?
                        </label>
                        <div class="grid grid-cols-2 gap-6">
                            <label @click="hasGalon = true" class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-md hover:shadow-lg group"
                                :class="hasGalon ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-300 bg-white hover:border-red-main/50'">
                                <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl mr-4 shadow-lg transition-colors"
                                    :class="hasGalon ? 'bg-red-main text-white shadow-red-main/30' : 'bg-gray-200 text-gray-600 group-hover:bg-red-main group-hover:text-white'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <div>
                                    <span class="font-extrabold text-gray-900 text-xl block">Ya, Isi Ulang</span>
                                    <span class="text-sm text-gray-600 block">Tukar dengan galon kosong</span>
                                </div>
                            </label>

                            <label @click="hasGalon = false; pilihanGalon = ''" class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-md hover:shadow-lg group"
                                :class="!hasGalon ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-300 bg-white hover:border-red-main/50'">
                                <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl mr-4 shadow-lg transition-colors"
                                    :class="!hasGalon ? 'bg-red-main text-white shadow-red-main/30' : 'bg-gray-200 text-gray-600 group-hover:bg-red-main group-hover:text-white'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="font-extrabold text-gray-900 text-xl block">Belum Ada, Botol Baru</span>
                                    <span class="text-sm text-gray-600 block">Beli galon baru + isi air</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Pilih Jenis Galon & Jumlah --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3 p-4 bg-gray-50 rounded-xl border-l-4 border-red-main/50 shadow-inner">
                            <label class="block text-xl font-bold text-gray-800 tracking-tight flex items-center">
                                <svg class="w-6 h-6 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0h10"></path></svg>
                                Pilih Jenis Galon
                            </label>
                            <p class="text-xs text-gray-500 ml-8">Pilih sesuai kebutuhan Anda (Isi Ulang/Botol Baru).</p>
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
                            <p class="text-xs text-gray-500 ml-8">Masukkan jumlah galon yang ingin Anda pesan.</p>
                            <input type="number" x-model.number="jumlah" min="1"
                                class="form-input-custom focus:ring-red-main focus:border-red-main text-gray-700 font-semibold text-center text-2xl"
                                placeholder="Min. 1" required>
                        </div>
                    </div>

                    {{-- Pilih Metode Pengambilan --}}
                    <div class="space-y-4">
                        <label class="block text-gray-800 font-bold text-xl md:text-2xl tracking-tight flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pilih Metode Pengambilan
                        </label>
                        <div class="grid grid-cols-2 gap-6">
                            <label @click="pengiriman = 'ambil'"
                                class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-md hover:shadow-lg group"
                                :class="pengiriman === 'ambil' ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-300 bg-white hover:border-red-main/50'">
                                <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl mr-4 shadow-lg transition-colors"
                                    :class="pengiriman === 'ambil' ? 'bg-red-main text-white shadow-red-main/30' : 'bg-gray-200 text-gray-600 group-hover:bg-red-main group-hover:text-white'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m-5 0v-2a2 2 0 012-2h10a2 2 0 012 2v2M7 5h10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-extrabold text-gray-900 text-xl block">Ambil Sendiri</span>
                                    <span class="text-sm text-gray-600 block">Gratis Tanpa Biaya</span>
                                </div>
                            </label>

                            <label @click="pengiriman = 'antar'"
                                class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-md hover:shadow-lg group"
                                :class="pengiriman === 'antar' ? 'border-red-main ring-4 ring-red-soft bg-red-soft/50 shadow-red-soft' : 'border-gray-300 bg-white hover:border-red-main/50'">
                                <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-xl mr-4 shadow-lg transition-colors"
                                    :class="pengiriman === 'antar' ? 'bg-red-main text-white shadow-red-main/30' : 'bg-gray-200 text-gray-600 group-hover:bg-red-main group-hover:text-white'">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-extrabold text-gray-900 text-xl block">Antar ke Kamar</span>
                                    <span class="text-sm text-gray-600 block">+ Rp <span x-text="(ongkir * jumlah).toLocaleString('id-ID')"></span></span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Catatan Tambahan --}}
                    <div class="space-y-3 p-6 bg-red-soft/20 rounded-2xl border-2 border-red-main/30 shadow-md">
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

                    {{-- TOMBOL LANJUT KE PEMBAYARAN (DI DALAM STEP 1) --}}
                    <button type="button" @click="if(pilihanGalon && jumlah >= 1) step = 2"
                        :disabled="!pilihanGalon || jumlah < 1"
                        class="group btn-solid-custom w-full py-5 rounded-xl font-extrabold uppercase tracking-widest text-lg shadow-xl shadow-red-main/30 disabled:opacity-30 disabled:cursor-not-allowed">
                        <span class="relative z-10 flex items-center justify-center gap-3 uppercase tracking-wider">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2h-1v1h1c1.657 0 3 .895 3 2s-1.343 2-3 2h-1c-1.657 0-3-.895-3-2s1.343-2 3-2h1v-1h-1c-1.657 0-3-.895-3-2s1.343-2 3-2z"></path></svg>
                            <span>Lanjut ke Pembayaran</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <div class="shimmer-effect"></div>
                    </button>

                </div>
                {{-- ============================== --}}
                {{-- STEP 1 - SELESAI --}}
                {{-- ============================== --}}


                {{-- ============================== --}}
                {{-- STEP 2 - MULAI --}}
                {{-- ============================== --}}
                <div x-show="step === 2" x-cloak class="space-y-10">

                    {{-- Tombol Kembali --}}
                    <a href="javascript:void(0)" @click="step = 1"
                        class="btn-back-style group inline-flex items-center text-gray-500 transition-all duration-300 active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-full border-2 shadow-md flex items-center justify-center mr-2 btn-back-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </div>
                        <span class="font-extrabold text-sm text-gray-900 transition-colors btn-back-text">Kembali ke Pemilihan Galon</span>
                    </a>

                    {{-- Judul --}}
                    <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        <span class="text-red-main">Metode</span> Pembayaran
                    </h3>

                    {{-- Kartu COD & Midtrans --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                    {{-- Total Pembayaran --}}
                    <div class="bg-red-soft/30 p-8 rounded-2xl border-2 border-red-main/50 flex flex-col sm:flex-row justify-between items-center shadow-lg shadow-red-main/10">
                        <div class="text-center sm:text-left mb-4 sm:mb-0">
                            <span class="font-extrabold text-red-main uppercase tracking-widest text-lg block">TOTAL PEMBAYARAN</span>
                            <span class="text-xs text-gray-700 font-semibold italic" x-text="'Rincian: ' + jumlah + 'x ' + pilihanGalon"></span>
                        </div>
                        <span class="font-black text-red-main text-4xl sm:text-5xl" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></span>
                    </div>

                    {{-- Tombol Konfirmasi --}}
                    <button id="btnFinalOrder" @click="handleOrder($data)"
                        class="group btn-solid-custom w-full py-5 rounded-xl font-extrabold uppercase tracking-widest text-lg shadow-xl shadow-red-main/30">
                        <span class="relative z-10 flex items-center justify-center gap-3 uppercase tracking-wider">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.003 12.003 0 0012 21.011a12.003 12.003 0 008.618-14.015z"></path></svg>
                            <span x-text="metode === 'cod' ? 'Konfirmasi & Pesan (Bayar di Tempat)' : 'Bayar Sekarang (Online Payment)'"></span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <div class="shimmer-effect"></div>
                    </button>

                </div>
                {{-- ============================== --}}
                {{-- STEP 2 - SELESAI --}}
                {{-- ============================== --}}

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
        <input type="hidden" name="metode_pengiriman">
        <input type="hidden" name="ongkir">
    </form>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
        const galons = @json($galons);

        async function handleOrder(alpineData) {
            const btn = document.getElementById('btnFinalOrder');
            const catatanValue = document.getElementById('catatanInput').value;

            if (alpineData.metode === 'cod') {
                const form = document.getElementById('realForm');
                form.querySelector('[name=nama_galon]').value = alpineData.pilihanGalon;
                form.querySelector('[name=jumlah]').value = alpineData.jumlah;
                form.querySelector('[name=catatan]').value = catatanValue;
                form.querySelector('[name=harga_satuan]').value = alpineData.hargaSatuan;
                form.querySelector('[name=metode_pengiriman]').value = alpineData.pengiriman;
                form.querySelector('[name=ongkir]').value = alpineData.pengiriman === 'antar' ? (alpineData.ongkir * alpineData.jumlah) : 0;
                form.submit();
            } else {
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
                                alert(`Terjadi error: ${err.message}`);
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