<style>
    /* Tombol Icon */
    .nav-icon-btn {
        position: relative;
        width: 44px;
        height: 44px;
        border-radius: 9999px;
        overflow: visible;
    }

    /* Layer Icon */
    .nav-icon-btn .icon-layer {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Shine Layer */
    .nav-icon-btn .shine-layer {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        overflow: hidden;
        z-index: 1;
    }

    .nav-icon-btn .shine-layer::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -60%;
        width: 20%;
        height: 200%;
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(30deg);
        transition: none;
    }

    /* Shine hanya saat hover & TIDAK aktif */
    .nav-icon-btn:not(.active):hover .shine-layer::after {
        left: 120%;
        transition: all 0.6s ease-in-out;
    }

    /* Badge */
    .nav-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 9999px;
        background: #DB4B3A;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        pointer-events: none;
        ring: 2px solid white;
    }

    /* Active state */
    .nav-icon-btn.active {
        background: #dc2626;
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
    }

    /* Klik animasi */
    .btn-active-scale:active {
        transform: scale(0.92);
    }

    /* Hover state untuk tombol yang tidak aktif */
    .nav-icon-btn:not(.active):hover {
        background-color: #fee2e2; /* Varian merah muda */
        color: #b91c1c; /* Varian merah gelap */
        border: 1px solid #fecaca;
    }

    /* Logo Glitch/Shine Effect */
    .logo-animate {
        position: relative;
        overflow: hidden;
        background: linear-gradient(90deg, #dc2626, #5B000B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Search Bar Focus Effect */
    .search-container-focus {
        box-shadow: 0 0 15px rgba(220, 38, 38, 0.15);
        transform: translateY(-1px);
    }

    /* Shine effect untuk Mobile Toggle */
    .shine-mobile {
        position: relative;
        overflow: hidden;
    }
    .shine-mobile::after {
        content: "";
        position: absolute;
        top: -50%; left: -60%;
        width: 20%; height: 200%;
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(30deg);
        transition: none;
    }
    .shine-mobile:hover::after {
        left: 120%;
        transition: all 0.6s ease-in-out;
    }

    input:focus {
    outline: none !important;
    }

    input:focus-visible {
        outline: none !important;
    }

    /* Profile Button Enhancements */
    .profile-btn-active {
        background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
        color: white !important;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
    }

    .profile-btn-idle {
        color: #1a1a1a;
        background: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .profile-btn-idle:hover {
        background-color: #fee2e2;
        color: #dc2626;
        border-color: #DB4B3A;
        box-shadow: 0 2px 10px rgba(220, 38, 38, 0.1);
    }

    /* Dropdown Item Styling */
    .dropdown-item-red {
        color: #1a1a1a;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .dropdown-item-red:hover {
        background-color: #fee2e2 !important;
        color: #b91c1c !important;
        border-left: 3px solid #dc2626;
        padding-left: 1.25rem !important;
    }

    /* Logout Button - Warna Utama #dc2626 */
    .dropdown-logout {
        background-color: transparent;
        color: #dc2626 !important;
        transition: all 0.3s ease;
    }

    .dropdown-logout:hover {
        background-color: #dc2626 !important; /* Warna Utama */
        color: white !important;
    }

    /* Icon Profile Container Animation */
    .profile-icon-container {
        position: relative;
        transition: transform 0.3s ease;
    }

    .btn-active-scale:hover .profile-icon-container {
        transform: scale(1.1);
    }

    /* Mobile Menu Link Enhancements */
    .mobile-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: #1a1a1a;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 0px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .mobile-link:hover {
        background: linear-gradient(90deg, #fee2e2 0%, transparent 100%);
        color: #dc2626;
        border-left: 4px solid #dc2626;
        padding-left: 1.25rem;
    }

    .mobile-link:active {
        background-color: #fecaca;
        transform: scale(0.98);
    }

    /* Mobile Search Input Enhancement */
    .mobile-search-input {
        border: 1px solid #5B000B !important;
        transition: all 0.3s ease;
        background-color: #f9fafb;
    }

    .mobile-search-input:focus {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1) !important;
        background-color: white;
    }

    /* Animation for Mobile Menu items */
    .mobile-menu-item {
        opacity: 0;
        transform: translateX(-10px);
        animation: slideInMobile 0.3s forwards;
    }

    @keyframes slideInMobile {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@php
    $isUser = auth()->check() && auth()->user()->role_id == 3;
@endphp

<nav x-data="{ open: false }"
     class="fixed top-0 z-50 w-full bg-white border-b border-[#930014]/20 shadow-sm">
    
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex h-20 items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">
                {{-- MOBILE TOGGLE (Improved) --}}
                <button @click="open = !open"
                        class="md:hidden w-10 h-10 flex items-center justify-center rounded-full text-black 
                               hover:bg-[#fee2e2] hover:text-[#dc2626] transition-all duration-300 
                               btn-active-scale shine-mobile border border-transparent hover:border-[#fecaca]">
                    <span class="w-6 h-6">
                        @include('icons.menu-icon')
                    </span>
                </button>

                {{-- LOGO (Improved) --}}
                <a href="/" class="text-2xl font-extrabold tracking-tighter btn-active-scale transition-all duration-300">
                    <span class="logo-animate group-hover:text-[#DB4B3A]">TJ&TMart</span>
                    <div class="h-0.5 w-0 group-hover:w-full bg-[#dc2626] transition-all duration-300"></div>
                </a>
            </div>

            {{-- SEARCH (Improved) --}}
            @if($isUser)
            <div x-data="{ focused: false }" class="relative flex-1 mx-4 max-w-xl hidden md:block">
                <form action="/search" method="GET" 
                      class="relative group transition-all duration-300"
                      :class="focused ? 'search-container-focus' : ''">
                    
                    {{-- SEARCH ICON --}}
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 transition-colors duration-300 z-10"
                          :class="focused ? 'text-[#dc2626]' : 'text-gray-400 group-hover:text-[#b91c1c]'">
                        @include('icons.search-icon')
                    </span>

                    {{-- INPUT --}}
                    <input type="text" name="q"
                        @focus="focused = true" @blur="focused = false"
                        class="w-full h-11 pl-11 pr-4 rounded-full border text-sm transition-all duration-300
                            focus:outline-none focus-visible:outline-none 
                            focus:ring-4 focus:ring-[#930013]/20 focus:border-[#930013]
                            bg-gray-50 group-hover:bg-white
                            text-black placeholder-gray-400"
                        :class="focused ? 'border-[#dc2626] bg-white' : 'border-[#5b000b]/70 group-hover:border-[#DB4B3A]'"
                        placeholder="Cari produk di TJ&TMart">
                    
                    {{-- DECORATIVE SHINE ON SEARCH (Optional) --}}
                    <div class="absolute inset-0 rounded-full pointer-events-none border border-transparent"
                         :class="focused ? 'border-[#dc2626]/20' : ''"></div>
                </form>
            </div>
            @endif

            {{-- RIGHT --}}
            <div class="flex items-center gap-3 md:gap-5">

                @if($isUser)
                {{-- WISHLIST --}}
                <a href="/wishlist"
                    class="nav-icon-btn btn-active-scale
                        relative shrink-0 hidden md:flex md:items-center 
                        md:justify-center w-11 h-11 rounded-full
                        transition-all duration-300 ease-in-out
                        {{ request()->is('wishlist*') ? 'active' : 'hover:bg-[#930014]/10 text-black hover:text-[#930014]' }}">

                    <span class="shine-layer"></span>

                    <span class="icon-layer w-6 h-6">
                        @include('icons.heart')
                    </span>

                    @auth
                        @if($wishlistCount > 0)
                            <span class="nav-badge absolute -top-1.5 -right-1.5 min-w-[13px] h-[13px]
                                        flex items-center justify-center
                                        bg-[#5B000B] text-white text-[10px] font-semibold
                                        rounded-full ring-2 ring-white animate-pulse">
                                {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                            </span>
                        @endif
                    @endauth
                </a>
                @endif

                @if($isUser)
                {{-- CART --}}
                <a href="/cart"
                    class="nav-icon-btn btn-active-scale 
                        relative shrink-0 flex items-center 
                        justify-center w-11 h-11 rounded-full
                        transition-all duration-300 ease-in-out
                        {{ request()->is('cart*') ? 'active' : 'hover:bg-[#930014]/10 text-black hover:text-[#930014]' }}">

                    <span class="shine-layer"></span>

                    <span class="icon-layer w-6 h-6">
                        @include('icons.cart')
                    </span>

                    @auth
                        @if($cartCount > 0)
                            <span class="nav-badge absolute -top-1.5 -right-1.5 min-w-[13px] h-[13px]
                                        flex items-center justify-center
                                        bg-[#5B000B] text-white text-[10px] font-semibold
                                        rounded-full ring-2 ring-white animate-pulse">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    @endauth
                </a>
                @endif
                @if($isUser)
                {{-- NOTIFICATION --}}
                <a href="/notifications"
                    class="nav-icon-btn btn-active-scale
                        relative shrink-0 hidden md:flex hidden md:flex md:items-center 
                        md:justify-center w-11 h-11 rounded-full
                        transition-all duration-300 ease-in-out
                        {{ request()->is('notifications*') ? 'active' : 'hover:bg-[#930014]/10 text-black hover:text-[#930014]' }}">

                    <span class="shine-layer"></span>

                    <span class="icon-layer w-6 h-6">
                        @include('icons.notification-icon')
                    </span>

                    @auth
                        @if($notifCount > 0)
                            <span class="nav-badge absolute -top-1.5 -right-1.5 min-w-[13px] h-[13px]
                                        flex items-center justify-center
                                        bg-[#5B000B] text-white text-[10px] font-semibold
                                        rounded-full ring-2 ring-white animate-pulse">
                                {{ $notifCount > 99 ? '99+' : $notifCount }}
                            </span>
                        @endif
                    @endauth
                </a>
                @endif
                {{-- PROFILE DROPDOWN --}}
                @auth
                @php
                    $user = Auth::user();
                    $navProfileImage = $user->gambar && file_exists(public_path('storage/'.$user->gambar))
                        ? asset('storage/'.$user->gambar)
                        : null;
                @endphp
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="shrink-0 flex items-center gap-2 px-3 h-11 rounded-full relative overflow-hidden transition-all duration-300 btn-active-scale shine-mobile group
                                {{ request()->routeIs('profile.*') ? 'profile-btn-active' : 'profile-btn-idle' }}">
                            
                            {{-- Shine effect layer --}}
                            <span class="shine-layer"></span>

                            <svg class="fill-current h-4 w-4 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            
                            <span class="text-sm font-bold tracking-tight">{{ Auth::user()->name }}</span>
                            
                            {{-- Profile Icon Wrapper --}}
                            <div class="profile-icon-container relative shrink-0 w-8 h-8 rounded-full overflow-hidden
                                        group-hover:border-[#dc2626] transition-colors
                                        flex items-center justify-center">

                                @if ($navProfileImage)
                                    <img src="{{ $navProfileImage }}" alt="Profil" class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center
                                                group-hover:text-[#dc2626]
                                                transition-colors">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            class="w-[77%] h-[77%]">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75
                                                    a7.488 7.488 0 0 0-5.982 2.975
                                                    m11.963 0a9 9 0 1 0-11.963 0
                                                    m11.963 0A8.966 8.966 0 0 1 12 21
                                                    a8.966 8.966 0 0 1-5.982-2.275
                                                    M15 9.75a3 3 0 1 1-6 0
                                                    3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Extra Inner Shadow for depth --}}
                                <div class="absolute inset-0 shadow-[inset_0_1px_3px_rgba(0,0,0,0.1)] pointer-events-none rounded-full"></div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Header Dropdown dengan Gradasi --}}
                        <div class="px-4 py-3 mb-1 bg-gradient-to-r from-white to-[#fee2e2]/30 border-b border-gray-100">
                            <p class="text-[10px] text-[#b91c1c] uppercase font-black tracking-widest">Manajemen Akun</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="dropdown-item-red font-medium">
                            <div class="flex items-center gap-2">
                                Pengaturan Profile
                            </div>
                        </x-dropdown-link>

                        <div class="border-t border-gray-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="dropdown-logout font-bold">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth

            </div>
        </div>
    </div>


    {{-- MOBILE MENU --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         @click.outside="open = false"
         class="md:hidden border-t border-[#fecaca] bg-white px-4 py-4 space-y-2 shadow-xl">

        {{-- SEARCH MOBILE --}}
        <form action="/search" method="GET" class="mb-4 mobile-menu-item" style="animation-delay: 0.05s">
            <div class="relative group">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#dc2626] transition-colors">
                    @include('icons.search-icon')
                </span>

                <input 
                    type="text"
                    name="q"
                    class="mobile-search-input w-full h-11 pl-10 pr-3 rounded-xl text-sm text-black focus:outline-none"
                    placeholder="Cari di TJ&TMart..."
                >
            </div>
        </form>

        {{-- MENU LINKS --}}
        <div class="space-y-1">
            <a href="/wishlist" class="mobile-link mobile-menu-item" style="animation-delay: 0.1s">
                <span class="text-[#dc2626]">@include('icons.heart')</span>
                <span>Wishlist</span>
                @auth @if($wishlistCount > 0)
                    <span class="ml-auto bg-[#dc2626] text-white text-[10px] px-2 py-0.5 rounded-full">{{ $wishlistCount }}</span>
                @endif @endauth
            </a>

            <a href="/notifications" class="mobile-link mobile-menu-item" style="animation-delay: 0.15s">
                <span class="text-[#dc2626]">@include('icons.notification-icon')</span>
                <span>Notifikasi</span>
                @auth @if($notifCount > 0)
                    <span class="ml-auto bg-[#dc2626] text-white text-[10px] px-2 py-0.5 rounded-full">{{ $notifCount }}</span>
                @endif @endauth
            </a>

            <a href="/kontak" class="mobile-link mobile-menu-item" style="animation-delay: 0.2s">
                <span class="text-[#dc2626]">@include('icons.phone-icon')</span>
                <span>Kontak</span>
            </a>

            <a href="/tentang-kami" class="mobile-link mobile-menu-item" style="animation-delay: 0.25s">
                <span class="text-[#dc2626]">@include('icons.info-icon')</span>
                <span>Tentang Kami</span>
            </a>

            {{-- Divider for Logout if Auth --}}
            @auth
                <div class="pt-2 mt-2 border-t border-gray-100 mobile-menu-item" style="animation-delay: 0.3s">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-link w-full text-[#b91c1c] font-bold hover:bg-[#5B000B] hover:text-white hover:border-[#5B000B]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>