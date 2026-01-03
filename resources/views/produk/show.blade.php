<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <style>
            .text-red-main { color: #dc2626; }
            .bg-red-main { background-color: #dc2626; }
            .btn-back-icon-only {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                color: #dc2626;
            }
            .btn-back-icon-only:hover {
                color: #b91c1c;
                transform: translateX(-3px);
            }
            /* Animasi tambahan untuk Gambar Produk */
            .product-image-container {
                position: relative;
                cursor: crosshair;
                transition: border-color 0.3s ease;
                border: 1px solid #e5e7eb;
            }
            .product-image-container:hover {
                border-color: #dc2626; /* Warna merah utama */
                box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.1), 0 8px 10px -6px rgba(220, 38, 38, 0.1);
            }
            .img-zoom {
                transition: transform 0.5s ease;
            }
            .product-image-container:hover .img-zoom {
                transform: scale(1.08);
            }        
            .img-magnifier-glass {
                position: fixed;
                border: 2px solid #dc2626; /* Warna merah utama */
                border-radius: 50%;
                cursor: crosshair;
                /* Ukuran lensa */
                width: 150px;
                height: 150px;
                display: none;
                pointer-events: none;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                z-index: 9999;
                transition: left 0.05s linear, top 0.05s linear;
            }
            /* Style tambahan untuk Informasi Produk */
            .select-variant {
                transition: all 0.2s ease;
                border: 1px solid #e5e7eb;
            }
            .select-variant:focus {
                border-color: #dc2626;
                ring: 2px;
                ring-color: rgba(220, 38, 38, 0.2);
                outline: none;
            }
            .mart-badge {
                transition: transform 0.2s ease;
            }
            .mart-badge:hover {
                transform: translateY(-2px);
            }
            /* Animasi & Style Baru untuk Informasi Produk */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-info { animation: fadeInUp 0.5s ease-out forwards; }
            
            .price-focus {
                text-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
            }            
            .stock-badge {
                border-left: 3px solid #dc2626;
                padding-left: 8px;
            }
            /* Animasi Idle untuk Harga */
            @keyframes priceGlow {
                0%, 100% { opacity: 1; filter: drop-shadow(0 0 0px rgba(220, 38, 38, 0)); }
                50% { opacity: 0.9; filter: drop-shadow(0 0 4px rgba(220, 38, 38, 0.3)); }
            }
            .animate-price-idle {
                animation: priceGlow 3s ease-in-out infinite;
            }

            /* Animasi Rating Berhasil */
            @keyframes ratingSuccess {
                0% { transform: scale(1); }
                50% { transform: scale(1.15); }
                100% { transform: scale(1); }
            }
            .rating-success-animate {
                animation: ratingSuccess 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                color: #fbbf24 !important; /* Warna kuning emas saat sukses */
            }
            /* Animasi Progress Bar */
            @keyframes growBar {
                from { width: 0; }
                to { width: var(--target-width); }
            }
            .animate-bar {
                animation: growBar 1s ease-out forwards;
            }

            /* Hover effect untuk Rating Input */
            .star-input {
                transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275), color 0.2s;
            }
            .star-input:hover {
                transform: scale(1.3) rotate(15deg);
            }

            /* Animasi tombol pada Action Card */
            .btn-action:hover {
                filter: brightness(1.1);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
            }
            /* Warna fokus input qty */
            #main-qty-input:focus {
                border-color: #dc2626;
                ring: 2px;
                outline: none;
                box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
            }

            /* Efek Kilau (Shine Animation) */
            @keyframes shine {
                100% { left: 125%; }
            }

            .btn-shining {
                position: relative;
                overflow: hidden;
            }

            .btn-shining::after {
                content: "";
                position: absolute;
                top: -50%;
                left: -75%;
                width: 50%;
                height: 200%;
                background: linear-gradient(
                    to right,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0) 100%
                );
                transform: rotate(30deg);
                transition: none;
            }

            .btn-shining:hover::after {
                animation: shine 0.8s forwards;
            }

            /* Animasi Idle Pulse untuk Tombol Utama */
            @keyframes softPulse {
                0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
                70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
                100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
            }

            .animate-buy-idle {
                animation: softPulse 2s infinite;
            }

            /* Refinement btn-action */
            .btn-action {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .btn-action:active {
                transform: scale(0.92) !important;
            }
        </style>

        <x-slot name="header">
            <div class="-my-5">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-0.5 pb-0.5">
                    {{-- Breadcrumb yang disesuaikan --}}
                    <nav class="flex mb-0" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-[11px]">
                            <li class="inline-flex items-center">
                                <a href="/" class="inline-flex items-center ms-0.5 text-[10px] font-semibold text-gray-500 hover:text-red-main transition-colors">
                                    <svg class="w-2 h-2 text-gray-400 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z"/>
                                    </svg>
                                    Beranda
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-2 h-2 text-gray-400 mx-0.5" fill="none" stroke="currentColor" viewBox="0 0 6 10">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <a href="{{ route('produk.index', ['kategori' => $produk->kategori?->id ?? '1']) }}" class="ms-0.5 text-[10px] font-semibold text-gray-500 hover:text-red-main transition-colors">
                                        {{ $produk->kategori?->nama_kategori ?? 'Tanpa Kategori' }}
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-2 h-2 text-gray-400 mx-0.5" fill="none" stroke="currentColor" viewBox="0 0 6 10">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="ms-0.5 text-[10px] font-extrabold text-red-main">{{ $produk->nama_produk }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
        
                    {{-- Container Judul dan Tombol Kembali (Tanpa Riwayat Transaksi) --}}
                    <div class="flex items-center justify-between mt-0.5">
                        <div class="flex items-center">
                            {{-- Tombol Kembali --}}
                            <a href="javascript:history.back()" 
                                class="btn-back-icon-only p-1.5 rounded-full mr-0.5 -ml-0.5 text-gray-500 hover:text-red-main active:scale-[0.98]">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                            </a>                    
                            {{-- Judul Halaman --}}
                            <h1 class="text-2xl sm:text-lg font-black text-gray-900 tracking-tight leading-none">
                                <span class="text-red-main uppercase mr-1">Detail</span><span class="text-black uppercase">Produk</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>


        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-7 gap-8 mt-6">
            {{-- Bagian Kiri: Gambar Produk --}}
            <div class="lg:col-span-2 flex justify-center">
                <div class="sticky top-24 w-full max-w-md">
                    <div id="magnifiable-container" class="product-image-container aspect-square bg-white rounded-[1.2rem] overflow-hidden shadow-sm">
                        <img id="product-img" 
                            src="{{ asset(str_replace('produk/', 'produk_assets/', $produk->gambar)) ? asset(str_replace('produk/', 'produk_assets/', $produk->gambar)) : asset('images/no-image.png') }}"
                            class="w-full h-full object-contain" 
                            alt="{{ $produk->nama_produk }}">
                    </div>
                </div>
            </div>

            {{-- Bagian Tengah: Informasi Produk --}}
            <div class="lg:col-span-3 space-y-2 animate-info">
                {{-- Nama Produk: Fokus pada ukuran dan aksen Merah --}}
                <h1 class="text-3xl font-black leading-tight text-gray-900 tracking-tight">
                    <span class="text-red-main decoration-red-main/20 decoration-4 underline-offset-4">
                        {{ $produk->nama_produk }}
                    </span>
                </h1>

                <div class="space-y-2 bg-gray-50/50 p-2.5 rounded-2xl border border-gray-100">
                    {{-- Bagian Harga: Dipercantik dengan shadow dan fokus merah --}}
                    <div class="price-focus animate-price-idle">
                        @php
                            $hargaAsli = $produk->harga;
                            $hargaDiskon = $produk->persentase_diskon ? $hargaAsli - ($hargaAsli * ($produk->persentase_diskon / 100)) : null;
                        @endphp
                        
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-black text-black">
                                Rp {{ number_format($hargaDiskon ?? $hargaAsli, 0, ',', '.') }}
                            </span>
                            @if($produk->persentase_diskon)
                                <span class="text-sm text-gray-400 line-through font-medium">
                                    Rp {{ number_format($hargaAsli, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        
                        @if($produk->persentase_diskon)
                            <span class="inline-flex items-center px-2 py-0.5 mt-0.5 text-[10px]">
                                Promo {{ $produk->persentase_diskon }}% OFF
                            </span>
                        @endif
                    </div>

                    {{-- Bagian Stok & Rating: Dikelompokkan lebih rapi --}}
                    <div class="flex flex-wrap items-center gap-3 pt-1.5 border-t border-gray-200/60">
                        {{-- Stok dengan style badge kiri --}}
                        <div class="stock-badge">
                            @if($produk->stok > 0)
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase font-bold text-gray-400 leading-none">Status Tersedia</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $produk->stok }} Stok</span>
                                </div>
                            @else
                                <span class="text-sm font-bold text-red-600">Stok Habis</span>
                            @endif
                        </div>

                        {{-- Rating dengan style modern --}}
                        <div class="pl-3 border-l border-gray-200 flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-gray-400 leading-none">Rating</span>
                            <div class="flex items-center gap-1.5">
                                <span class="text-sm font-bold text-gray-800">{{ round($produk->reviews->avg('rating') ?? 0, 1) }}</span>
                                <div class="flex text-yellow-400 text-xs">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ ($produk->reviews->avg('rating') ?? 0) >= $i ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-[11px] text-gray-400 font-medium">({{ $produk->reviews->count() }} Pengulas)</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- List Toko/Mart --}}
                <div class="space-y-1.5">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Lokasi Ketersediaan Produk:</div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($produk->highlightedMarts() as $mart)
                            <span class="mart-badge inline-flex items-center px-3 py-1.5 rounded-xl text-[11px] font-bold transition-all
                                {{ $mart['is_active'] ? 'bg-white text-red-600 border-2 border-red-500 shadow-sm' : 'bg-gray-100 text-gray-400 border border-transparent' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $mart['is_active'] ? 'bg-red-500 animate-pulse' : 'bg-gray-300' }}"></span>
                                {{ $mart['nama'] }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Variasi --}}
                @if ($produk->variants->count())
                    <div class="space-y-1.5">
                        <label class="font-bold text-[11px] text-gray-400 uppercase tracking-widest flex items-center">
                            Pilih Variasi Produk
                        </label>
                        <select class="select-variant w-full rounded-2xl px-3 py-2 text-sm bg-white shadow-sm font-semibold text-gray-700 border-gray-200">
                            @foreach ($produk->variants as $variant)
                                <option>{{ $variant->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Deskripsi dengan Border Kiri Merah --}}
                <div class="pt-2 border-t border-gray-100">
                    <h3 class="font-bold text-sm mb-1.5 text-gray-900 flex items-center uppercase tracking-tight">
                        <svg class="w-4 h-4 mr-2 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Deskripsi Produk
                    </h3>
                    <div class="pl-4 border-l-2 border-red-main/20">
                        <p class="text-xs text-gray-600 leading-snug italic">
                            {{ $produk->deskripsi }}
                        </p>
                    </div>
                </div>

                {{-- USER RATING --}}
                @auth
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-700 mb-1">
                        Beri Rating Produk
                    </p>
    
                    <form id="rating-form" action="{{ route('produk.rating.store', $produk->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="rating" id="rating-input">

                        <div class="flex gap-1 text-3xl cursor-pointer select-none" id="star-rating">
                            <div id="rating-container" class="flex gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span
                                        data-value="{{ $i }}"
                                        class="star star-input text-yellow-400 hover:text-red-main transition-all duration-300">
                                        <svg class="w-11 h-11 {{ ($produk->reviews->avg('rating') ?? 0) >= $i ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </span>
                                @endfor
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="mt-1.5 text-xs px-3 py-1.5 font-bold text-white bg-red-main rounded-lg hover:bg-red-700 transition-all active:scale-95 shadow-sm">
                            Kirim Rating
                        </button>
                    </form>
                </div>
                @endauth

                {{-- RATING STATISTIK (Sederhana & Bersih dengan Aksen Merah) --}}
                <div class="bg-white p-3 rounded-2xl space-y-2">
                    <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2">Statistik Rating</h4>
                    @for ($i = 5; $i >= 1; $i--)
                        @php
                            $count = $ratingStats[$i] ?? 0;
                            $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-3 text-[10px] font-bold text-gray-600 group">
                            <span class="w-4 group-hover:text-red-main transition-colors">{{ $i }}★</span>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden border border-gray-50">
                                <div class="h-full bg-red-main rounded-full animate-bar shadow-[0_0_8px_rgba(220,38,38,0.2)]" 
                                    style="--target-width: {{ $percent }}%; width: {{ $percent }}%"></div>
                            </div>
                            <span class="w-8 text-right text-gray-400">{{ $percent }}%</span>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Bagian Kanan: Sticky Action Card --}}
            <div class="lg:col-span-2">
                <div class="sticky top-36 bg-white border rounded-[1.2rem] p-4 space-y-4 shadow-sm border-gray-100">
                    <div>
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Jumlah Pesanan</label>
                        <input type="number" id="main-qty-input" min="1" value="1" max="{{ $produk->stok }}"
                            class="mt-1.5 w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-bold transition-all outline-none">
                    </div>

                    <div class="text-sm text-gray-600 font-medium">
                        Subtotal:
                        <span class="font-black text-xl text-red-main block" id="display-subtotal">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Tombol Wishlist --}}
                        <form method="POST" action="{{ route('wishlist.store') }}">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <button type="submit"
                                class="btn-action btn-shining w-12 h-12 bg-white border-2 border-red-main rounded-xl flex items-center justify-center text-red-main hover:bg-red-50 hover:text-red-main hover:border-red-700 transition shadow-sm active:bg-red-700">
                                <div class="transform transition-transform group-hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke-width="3" 
                                        stroke="currentColor" 
                                        class="size-6">
                                        <path stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </div>
                            </button>
                        </form>

                        {{-- Form Add to Cart --}}
                        <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="qty" value="1" id="cart-qty-hidden">
                            <button type="submit"
                                class="btn-action btn-shining w-full font-black py-2.5 bg-white border-2 border-red-main rounded-xl flex items-center justify-center text-red-main hover:bg-red-50 hover:border-red-700 transition shadow-sm gap-2">
                                <span>+ Keranjang</span>      
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    {{-- Form Checkout Langsung --}}
                    <form action="{{ route('checkout.direct') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $produk->id }}">
                        <input type="hidden" name="qty" value="1" id="checkout-qty-hidden">

                        <button type="submit"
                            class="btn-action btn-shining animate-buy-idle w-full bg-red-main text-white py-3 font-black rounded-xl text-sm shadow-lg hover:bg-red-700 hover:shadow-red-500/40">
                            <span class="flex items-center justify-center gap-2">
                                Beli Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </button>
                    </form>
                    
                    <p class="text-[10px] text-gray-400 text-center italic">
                        *Pastikan produk dan jumlah yang ingin dibeli sudah benar
                    </p>
                </div>
            </div>
        </div>

        {{-- Produk Rekomendasi --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-10">
            <h2 class="text-lg font-black text-[#5B000B] mb-4">Produk Serupa</h2>
            @include('produk._recommendation', ['produk' => $rekomendasi])
        </div>

        {{-- Script Sinkronisasi --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Logika Magnifier
                const container = document.getElementById('magnifiable-container');
                const img = document.getElementById('product-img');

                if (!container || !img) return;

                const glass = document.createElement("div");
                glass.className = "img-magnifier-glass";
                document.body.appendChild(glass); // FIXED → body

                const zoom = 2;

                function moveMagnifier(e) {
                    const rect = img.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    // Jika cursor keluar gambar → sembunyikan
                    if (x < 0 || y < 0 || x > rect.width || y > rect.height) {
                        glass.style.display = "none";
                        return;
                    }

                    glass.style.display = "block";

                    const glassSize = glass.offsetWidth / 2;
                    const offset = 10; // jarak dari cursor (biar tidak nutup)

                    // POSISI LENS DEKAT CURSOR
                    glass.style.left = (e.clientX + offset) + "px";
                    glass.style.top  = (e.clientY + offset) + "px";

                    // ZOOM IMAGE
                    glass.style.backgroundImage = `url('${img.src}')`;
                    glass.style.backgroundRepeat = "no-repeat";
                    glass.style.backgroundSize =
                        (rect.width * zoom) + "px " + (rect.height * zoom) + "px";

                    glass.style.backgroundPosition =
                        "-" + ((x * zoom) - glassSize) + "px -" +
                        ((y * zoom) - glassSize) + "px";
                }

                container.addEventListener("mousemove", moveMagnifier);
                container.addEventListener("mouseleave", () => glass.style.display = "none");

                // STAR RATING INTERACTION
                const stars = document.querySelectorAll('#star-rating .star');
                const ratingInput = document.getElementById('rating-input');

                if (stars.length) {
                    stars.forEach(star => {
                        star.addEventListener('click', () => {
                            const value = star.dataset.value;
                            ratingInput.value = value;

                            stars.forEach(s => {
                                const svg = s.querySelector('svg');
                                
                                if (s.dataset.value <= value) {
                                    svg.classList.remove('text-gray-300');
                                    svg.classList.add('text-yellow-400', 'fill-current');
                                } else {
                                    svg.classList.remove('text-yellow-400', 'fill-current');
                                    svg.classList.add('text-gray-300');
                                }
                            });
                        });
                    });
                }

                const ratingForm = document.getElementById('rating-form');
                const ratingContainer = document.getElementById('rating-container');

                if (ratingForm && ratingContainer) {
                    ratingForm.addEventListener('submit', function(e) {
                        // Kita berikan efek animasi sesaat sebelum/saat proses kirim
                        ratingContainer.classList.add('rating-success-animate');
                        
                        // Opsional: Jika Anda ingin animasi terlihat jelas sebelum redirect/refresh
                        // hapus class setelah animasi selesai
                        setTimeout(() => {
                            ratingContainer.classList.remove('rating-success-animate');
                        }, 1000);
                    });
                }

                // Jika ulasan berhasil diperbaharui (deteksi lewat session Laravel)
                @if(session('success'))
                    const ratingContainerEl = document.getElementById('rating-container');
                    if (ratingContainerEl) {
                        ratingContainerEl.classList.add('rating-success-animate');
                    }
                @endif
                
                // Script sinkronisasi jumlah
                const qtyInput = document.getElementById('main-qty-input');
                const cartQtyHidden = document.getElementById('cart-qty-hidden');
                const checkoutQtyHidden = document.getElementById('checkout-qty-hidden');
                const displaySubtotal = document.getElementById('display-subtotal');

                const hargaProduk = {{ $produk->harga }};

                function updateSubtotal() {
                    let val = parseInt(qtyInput.value);

                    if (isNaN(val) || val < 1) {
                        val = 1;
                        qtyInput.value = 1;
                    }

                    cartQtyHidden.value = val;
                    checkoutQtyHidden.value = val;

                    const total = hargaProduk * val;
                    displaySubtotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
                }

                // PASANG EVENT
                qtyInput.addEventListener('input', updateSubtotal);
                qtyInput.addEventListener('change', updateSubtotal);

                // JALANKAN SEKALI SAAT LOAD
                updateSubtotal();
            });
        </script>
    </div>
</x-app-layout>
