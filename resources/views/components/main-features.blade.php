@props([
    'banners' => [],
    'latestProducts' => []
])

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(231, 189, 138, 0.2);
    }
    .feature-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }
    .product-gradient {
        background: linear-gradient(to top, rgba(220, 38, 38, 0.9), transparent);
    }

    @keyframes shine {
        100% { left: 125%; }
    }

    .shining-effect {
        position: relative;
        overflow: hidden;
    }

    .shining-effect::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -60%;
        width: 20%;
        height: 200%;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(30deg);
        transition: none;
    }

    .shining-effect:hover::after {
        animation: shine 0.8s forwards;
    }

    .badge-history-style {
        transition: all 0.3s ease;
        background-color: #ffffff;
        border: 0.3px solid rgba(220, 38, 38, 0.5); 
        color: #dc2626;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.15); 
    }

    .badge-history-style:hover {
        box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
        border-color: #dc2626;
        transform: translateY(-2px);
        background-color: rgba(254, 226, 226, 0.5);
    }

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .product-scrollbar {
        scrollbar-width: thin;           
        scrollbar-color: #dc2626 #fef2f2;   
    }

    .product-scrollbar::-webkit-scrollbar {
        height: 8px;
    }

    .product-scrollbar::-webkit-scrollbar-track {
        background: #fef2f2;
        border-radius: 999px;
    }

    .product-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #dc2626, #b91c1c);
        border-radius: 999px;
    }

    .product-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to right, #b91c1c, #991b1b);
    }

    .product-card-container {
        perspective: 1000px;
    }

    .product-image-glow {
        transition: all 0.5s ease;
    }

    .group:hover .product-image-glow {
        box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.4);
    }

    .new-badge-pulse {
        animation: badge-pulse 2s infinite;
    }

    @keyframes badge-pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(220, 38, 38, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }

    .scroll-smooth {
        scroll-behavior: smooth;
    }
</style>

<div 
    x-data="{ 
        scrolled: false,
        openGroup: null,
        hoverTimer: null
    }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-6"
>
    {{-- ONE UNIFIED BACKGROUND WITH MODERN TOUCH --}}
    <div class="bg-white rounded-[1.5rem] shadow-2xl shadow-red-900/5 border border-[#E7BD8A]/20 overflow-hidden">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">

            {{-- ================= LEFT SIDE (WELCOME & NAV) ================= --}}
            {{-- Ganti baris ini --}}
            <div class="lg:col-span-4 p-6 lg:pt-7 lg:pb-4 bg-gradient-to-br from-white via-[#fff1f1] to-[#fecaca] border-r border-[#E7BD8A]/10 flex flex-col justify-between">
                <div>
                    @auth
                        <div class="relative mb-1">
                            <h2 class="text-2xl font-black text-[#5B000B] leading-tight tracking-tight">
                                Selamat datang,<br/>
                                <span class="relative inline-block">
                                    <span class="relative z-10 text-[#dc2626]">{{ auth()->user()->name }}</span>
                                    <span class="absolute bottom-1 left-0 w-full h-2 bg-[#fecaca] -z-0 rounded-sm"></span>
                                </span>
                            </h2>

                            {{-- Building & Room Badges --}}
                            <div class="mt-4 flex items-center gap-2 text-xs font-bold">
                                {{-- Badge Gedung --}}
                                <div class="badge-history-style flex items-center gap-2 px-3 py-1.5 rounded-xl">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m-5 0v-2a2 2 0 012-2h10a2 2 0 012 2v2M7 5h10"></path>
                                    </svg>
                                    <span class="text-[10px] leading-tight font-bold tracking-wider">{{ auth()->user()->alamat_gedung ?? 'Gedung -' }}</span>
                                </div>
                                
                                {{-- Badge Kamar --}}
                                <div class="badge-history-style flex items-center gap-2 px-3 py-1.5 rounded-xl">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span class="text-[10px] leading-tight font-bold tracking-wider">Kamar {{ auth()->user()->nomor_kamar ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="mt-5 relative">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#dc2626] to-transparent rounded-full"></div>
                                <p class="pl-4 text-gray-500 leading-relaxed text-xs antialiased font-medium">
                                    Permudah penuhi setiap kebutuhan asramamu dengan sistem yang <span class="text-[#dc2626] font-bold">terintegrasi</span>, cepat, dan aman.
                                </p>
                            </div>
                        </div>
                    @endauth

                    <h4 class="text-[10px] font-extrabold text-[#dc2626] uppercase tracking-[0.2em] mt-2 mb-2 ml-1">Layanan Utama</h4>

                    <div class="flex flex-row md:flex-row lg:flex-col gap-2 lg:gap-1.5">
                        {{-- Token --}}
                        <a href="{{ route('token.index') }}"
                        class="feature-card shining-effect w-full lg:w-auto group flex items-center gap-3 px-4 py-3 rounded-2xl bg-white border-2 border-red-300 hover:border-[#dc2626] hover:shadow-xl hover:shadow-red-900/10 transition-all">
                            <div class="w-12 h-12 shrink-0 flex items-center justify-center bg-[#dc2626] rounded-xl text-white group-hover:bg-[#b91c1c] transition-all duration-300 shadow-lg shadow-red-200">
                                @include('icons.electricity')
                            </div>
                            <div>
                                <h3 class="font-bold text-[#5B000B] text-[13px] group-hover:text-[#dc2626]">Token Listrik</h3>
                                <p class="text-[10px] leading-tight text-red-400 font-bold uppercase tracking-tighter">Beli Sekarang</p>
                            </div>
                            <div class="ml-auto opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                <svg class="w-5 h-5 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </a>
                        {{-- Galon --}}
                        <a href="{{ route('galon.index') }}"
                        class="feature-card shining-effect w-full lg:w-auto group flex items-center gap-3 px-4 py-3 rounded-2xl bg-white border-2 border-red-300 hover:border-[#dc2626] hover:shadow-xl hover:shadow-red-900/10 transition-all">
                            <div class="w-12 h-12 shrink-0 flex items-center justify-center bg-[#dc2626] rounded-xl text-white group-hover:bg-[#b91c1c] transition-all duration-300 shadow-lg shadow-red-200">
                                @include('icons.gallon')
                            </div>
                            <div>
                                <h3 class="font-bold text-[#5B000B] text-[13px] group-hover:text-[#dc2626]">Galon Asrama</h3>
                                <p class="text-[10px] leading-tight text-red-400 font-bold uppercase tracking-tighter">Pesan Antar</p>
                            </div>
                            <div class="ml-auto opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                <svg class="w-5 h-5 text-[#dc2626]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </div>
                        </a>
                    </div>
                    {{-- SMALL TAGLINE TO BALANCE HEIGHT --}}
                    <div class="mt-2 border-t border-gray-100/60 hidden lg:block">
                        <div class="flex items-center gap-2 opacity-60">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#5B000B]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-7.5l2.5-2.5 1.5 1.5-4 4-2.5-2.5 1.5-1.5 1 1z"/></svg>
                            </div>
                            <p class="text-[10px] font-medium text-gray-500 leading-snug">
                                Layanan terpercaya untuk kebutuhan asrama Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= RIGHT SIDE (PRODUCT SHOWCASE) ================= --}}
            @php $groups = collect($latestProducts)->chunk(4); @endphp
            <div class="lg:col-span-8 bg-white flex flex-col">
                {{-- INTEGRATED BANNER --}}
                <div class="relative overflow-hidden shadow-xl shadow-red-900/5 border border-[#dc2626] group/banner">
                    <div id="banner-track" class="flex transition-transform duration-1000 cubic-bezier(0.4, 0, 0.2, 1)">
                        @forelse($banners ?? [] as $banner)
                            <a href="{{ $banner->redirect_url ?? '#' }}" class="min-w-full relative group/item">
                                <div class="w-full h-24 md:h-28 lg:h-32 relative overflow-hidden">
                                    <img src="{{ asset('banners/' . $banner->image_path) }}" 
                                        class="w-full h-full object-cover transform transition-transform duration-[2000ms] group-hover/item:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                    <div class="absolute inset-0 bg-gradient-to-r from-black/20 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#dc2626] to-transparent opacity-50"></div>
                                </div>
                            </a>
                        @empty
                            <div class="min-w-full h-32 bg-gray-100 flex items-center justify-center">
                                <p class="text-gray-400 text-sm italic">Belum ada promo tersedia</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Manual Navigation Arrows --}}
                    @if(count($banners ?? []) > 1)
                        <button onclick="prevBanner()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/90 backdrop-blur-md text-white hover:text-[#dc2626] p-1.5 rounded-full transition-all opacity-0 group-hover/banner:opacity-100 z-10 border border-white/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button onclick="nextBanner()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/90 backdrop-blur-md text-white hover:text-[#dc2626] p-1.5 rounded-full transition-all opacity-0 group-hover/banner:opacity-100 z-10 border border-white/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        {{-- Navigation Indicators (Modern Clickable Dots) --}}
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            @foreach($banners as $index => $b)
                                <button 
                                    onclick="goToBanner({{ $index }})" 
                                    class="banner-dot h-1.5 rounded-full bg-white/40 backdrop-blur-sm transition-all duration-500 hover:bg-white {{ $loop->first ? 'w-6 bg-white' : 'w-2' }}" 
                                    id="dot-{{ $index }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-8 p-6 lg:pt-7 lg:pb-4 bg-white">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-xl font-black text-[#5B000B]">Katalog Produk Terbaru</h3>
                            <div class="h-1 w-10 bg-[#dc2626] rounded-full mt-1.5"></div>
                        </div>
                    </div>

                    
                    <div class="relative group/katalog">
                        {{-- Navigation Buttons - Only visible on LG screens when hovered --}}
                        <div class="hidden md:block">
                            <button @click="$refs.productScroll.scrollBy({left: -320, behavior: 'smooth'})" 
                                class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 bg-white shadow-xl border border-red-100 p-2 rounded-full text-[#dc2626] hover:bg-[#dc2626] hover:text-white transition-all duration-300 md:opacity-100 lg:opacity-0 lg:group-hover/katalog:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button @click="$refs.productScroll.scrollBy({left: 320, behavior: 'smooth'})" 
                                class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 bg-white shadow-xl border border-red-100 p-2 rounded-full text-[#dc2626] hover:bg-[#dc2626] hover:text-white transition-all duration-300 md:opacity-100 lg:opacity-0 lg:group-hover/katalog:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
    
                        {{-- SCROLLABLE CONTAINER --}}
                        <div x-ref="productScroll" class="flex gap-5 overflow-x-auto product-scrollbar pb-3 -mx-2 px-2 snap-x snap-mandatory scroll-smooth">
                            @foreach($latestProducts as $product)
                                <div class="relative pt-2 snap-start shrink-0 w-[160px] product-card-container">
                                    <a href="{{ route('produk.show', $product->id) }}"
                                        class="group/item block relative aspect-square rounded-[1.2rem] overflow-hidden border-2 border-red-50 bg-white shadow-sm hover:shadow-2xl hover:border-red-500 transition-all duration-500 transform hover:-translate-y-1">
                                        {{-- Product Image --}}
                                        <img src="{{ asset(str_replace('produk/', 'produk_assets/', $product->gambar)) }}"
                                            alt="{{ $product->nama_produk }}"
                                            class="w-full h-full object-cover transition-transform duration-1000 group-hover/item:scale-110 group-hover/item:rotate-2">
    
                                        {{-- Enhanced Overlay --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#dc2626] via-[#dc2626]/20 to-transparent opacity-0 group-hover/item:opacity-100 transition-all duration-300 flex flex-col justify-end p-4">
                                            <p class="text-white font-bold text-[11px] leading-tight translate-y-2 group-hover/item:translate-y-0 transition-transform duration-300 truncate">
                                                {{ $product->nama_produk }}
                                            </p>
                                            <span class="text-[9px] text-red-100 font-medium opacity-0 group-hover/item:opacity-100 transition-opacity delay-100">Klik untuk detail ➔</span>
                                        </div>
    
                                        {{-- Pulse Badge --}}
                                        <div class="absolute top-2.5 left-2.5">
                                            <div class="new-badge-pulse bg-white/95 backdrop-blur-sm px-2 py-0.5 rounded-lg text-[8px] font-black text-[#dc2626] flex items-center gap-1 shadow-sm border border-red-100">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-600"></span>
                                                </span>
                                                NEW
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('banner-track');
        const dots = document.querySelectorAll('.banner-dot');

        if (!track || dots.length === 0) return;

        const totalBanners = track.children.length;
        let currentIndex = 0;
        let interval = null;

        function updateBannerDisplay() {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            dots.forEach((dot, i) => {
                if (i === currentIndex) {
                    dot.classList.add('w-6', 'bg-white');
                    dot.classList.remove('w-2', 'bg-white/40');
                } else {
                    dot.classList.remove('w-6', 'bg-white');
                    dot.classList.add('w-2', 'bg-white/40');
                }
            });
        }

        function nextBanner() {
            currentIndex = (currentIndex + 1) % totalBanners;
            updateBannerDisplay();
        }

        function prevBanner() {
            currentIndex = (currentIndex - 1 + totalBanners) % totalBanners;
            updateBannerDisplay();
        }

        function goToBanner(index) {
            currentIndex = index;
            updateBannerDisplay();
            resetAutoSlide();
        }

        function startAutoSlide() {
            if (totalBanners <= 1) return;
            interval = setInterval(nextBanner, 5000);
        }

        function resetAutoSlide() {
            clearInterval(interval);
            startAutoSlide();
        }

        window.nextBanner = () => {
            nextBanner();
            resetAutoSlide();
        };

        window.prevBanner = () => {
            prevBanner();
            resetAutoSlide();
        };

        window.goToBanner = (index) => {
            goToBanner(index);
        };

        updateBannerDisplay();
        startAutoSlide();
    });
</script>