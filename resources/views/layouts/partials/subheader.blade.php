<style>
    .bg-sub-header {
        background: linear-gradient(135deg, #5B000B, #dc2626, #b91c1c, #5B000B);
        background-size: 300% 300%;
        animation: gradientAnimation 8s ease infinite;
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .nav-link-shine {
        position: relative;
        overflow: hidden;
    }

    .nav-link-shine::before {
        content: "";
        position: absolute;
        top: 0;
        left: -150%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.4),
            transparent
        );
        transition: all 0.7s cubic-bezier(0.19, 1, 0.22, 1);
    }

    .nav-link-shine:hover::before {
        left: 150%;
    }

    /* Animasi Klik Berdenyut (Pulse) */
    .btn-click-effect:active {
        transform: scale(0.92);
        filter: brightness(1.2);
        transition: transform 0.1s;
    }

    /* Peningkatan Glassmorphism dengan skema warna spesifik */
    .mart-button-premium {
        background: linear-gradient(135deg, rgba(91, 0, 11, 0.4), rgba(185, 28, 28, 0.2));
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(231, 189, 138, 0.4);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3), inset 0 0 15px rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    /* Efek Hover: Berubah menjadi gradasi emas ke merah gelap */
    .mart-button-premium:hover {
        background: linear-gradient(135deg, #5B000B, #b91c1c);
        border-color: #E7BD8A;
        box-shadow: 0 0 25px rgba(220, 38, 38, 0.5);
        transform: translateY(-1px);
    }

    /* Efek Shining Kristal Putih yang lebih tajam */
    .crystal-shine {
        position: relative;
        overflow: hidden;
    }

    .crystal-shine::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -150%;
        width: 80%;
        height: 200%;
        background: linear-gradient(
            to right,
            transparent,
            rgba(255, 255, 255, 0.6),
            transparent
        );
        transform: rotate(35deg);
        transition: all 0.8s cubic-bezier(0.19, 1, 0.22, 1);
    }

    .mart-button-premium:hover.crystal-shine::after {
        left: 150%;
    }

    /* Pulse animation khusus untuk Pin Icon saat hover */
    .mart-button-premium:hover .floating-icon {
        animation: pinPulse 1.5s infinite;
    }

    @keyframes pinPulse {
        0% { transform: scale(1); filter: drop-shadow(0 0 0px #E7BD8A); }
        50% { transform: scale(1.2); filter: drop-shadow(0 0 8px #E7BD8A); }
        100% { transform: scale(1); filter: drop-shadow(0 0 0px #E7BD8A); }
    }

    /* Floating Animation untuk Icon */
    .floating-icon {
        animation: miniFloat 2s ease-in-out infinite;
    }

    @keyframes miniFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-2px); }
    }
</style>

{{-- SUB HEADER NAVIGATION --}}
<div 
    x-data="{ openMart: false }"
    class="fixed top-[80px] z-40 w-full bg-sub-header text-white shadow-[0_4px_20px_rgba(0,0,0,0.3)] border-b border-[#E7BD8A]/30"
>
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-10 text-sm overflow-hidden">

            {{-- LEFT MENU --}}
            <ul class="flex items-center gap-4 font-semibold h-full">
                @php
                    $links = [
                        ['name' => 'Beranda', 'url' => '/'],
                        ['name' => 'Produk', 'url' => route('produk.index')],
                        ['name' => 'Kontak', 'url' => '/kontak', 'mobile_hidden' => true],
                        ['name' => 'Tentang Kami', 'url' => '/tentang-kami', 'mobile_hidden' => true],
                    ];
                @endphp

                @foreach($links as $index => $link)
                    @if($index > 0)
                        <li class="h-5 w-[1px] bg-gradient-to-b from-transparent via-[#E7BD8A]/40 to-transparent {{ ($link['mobile_hidden'] ?? false) ? 'hidden md:block' : '' }}"></li>
                    @endif

                    <li class="{{ ($link['mobile_hidden'] ?? false) ? 'hidden md:block' : '' }} h-full flex items-center">
                        <a href="{{ $link['url'] }}" 
                           class="nav-link-shine btn-click-effect relative flex items-center h-full px-3 transition-all duration-300 hover:text-[#fee2e2] group">
                            <span class="relative z-10">{{ $link['name'] }}</span>
                            
                            {{-- Glow Background on Hover --}}
                            <span class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></span>
                            
                            {{-- Animated Underline (Red to Gold Gradient) --}}
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[3px] bg-gradient-to-r from-[#dc2626] via-[#E7BD8A] to-[#dc2626] transition-all duration-500 group-hover:w-full"></span>
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- RIGHT PRIORITY MART (MART BUTTON) --}}
            <button
                @click="openMart = true"
                class="mart-button-premium crystal-shine btn-click-effect flex items-center gap-2 px-3 h-8 rounded-full
                       text-white transition-all duration-300 group overflow-hidden"
            >
                <div class="flex flex-col items-end leading-none">
                    <span class="text-[8px] leading-none uppercase tracking-[0.12em] text-[#fecaca] font-black group-hover:text-white transition-colors duration-300">
                        Prioritas Toko
                    </span>
                </div>
                
                {{-- Icon Container dengan varian warna #5B000B dan #dc2626 --}}
                <div class="p-1.5 bg-gradient-to-br from-[#5B000B] to-[#b91c1c] rounded-full 
                            group-hover:from-[#dc2626] group-hover:to-[#DB4B3A] transition-all duration-300 shadow-lg border border-white/10">
                    <div class="floating-icon text-[#E7BD8A] group-hover:text-white transition-colors duration-300">
                        @include('icons.map-pin-icon')
                    </div>
                </div>

                <span class="font-extrabold text-transparent bg-clip-text
                            bg-gradient-to-r from-[#E7BD8A] to-[#E68757]
                            group-hover:from-white group-hover:to-[#fee2e2]
                            transition-all duration-300 drop-shadow-md
                            max-w-[140px] truncate whitespace-nowrap">
                    {{ $activeMart->nama_mart ?? 'Semua Mart' }}
                </span>
            </button>
        </div>
    </div>

    {{-- MODAL --}}
    @include('partials.mart-selector')
</div>