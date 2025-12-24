<nav x-data="{ open: false }"
     class="sticky top-0 z-50 bg-white border-b border-[#E7BD8A]/40 backdrop-blur">

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex h-20 items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">

                {{-- MOBILE TOGGLE --}}
                <button @click="open = !open"
                        class="md:hidden text-black hover:text-[#5B000B] transition">
                    <span class="w-6 h-6">
                        @include('icons.menu-icon')
                    </span>
                </button>

                {{-- LOGO --}}
                <a href="/" class="text-xl font-bold tracking-wide text-[#930014] hover:text-[#DB4B3A] transition">
                    TJ&TMart
                </a>

            </div>

            {{-- CATEGORY --}}
            <div class="hidden md:flex items-center">
                <a href="/category"
                class="px-4 py-2 rounded-full text-sm font-medium
                       text-black
                       hover:bg-[#E7BD8A]/40
                       hover:text-[#DB4B3A]
                       transition">
                    Kategori
                </a>
            </div>

            {{-- SEARCH --}}
            <div x-data="{ focused: false }" class="relative flex-1 mx-4 max-w-xl">
                <form action="/search" method="GET" class="relative">

                    {{-- SEARCH ICON --}}
                    <span 
                        class="absolute left-4 top-1/2 -translate-y-1/2
                            transition-colors duration-200
                            text-black"
                        :class="focused ? 'text-[#930014]' : 'text-black'"
                    >
                        @include('icons.search-icon')
                    </span>

                    {{-- INPUT --}}
                    <input 
                        type="text"
                        name="q"
                        @focus="focused = true"
                        @blur="focused = false"
                        class="w-full h-11 pl-11 pr-2 rounded-full
                            border border-black
                            text-sm text-black
                            focus:outline-none
                            focus:ring-1 focus:ring-[#930013]
                            focus:border-[#930013]
                            transition"
                        placeholder="Cari produk di TJ&TMart"
                    >
                </form>
            </div>

            {{-- RIGHT --}}
            <div class="flex items-center gap-3 md:gap-5">

                {{-- WISHLIST --}}
                <a href="/wishlist"
                   class="relative shrink-0 hidden md:flex items-center justify-center w-11 h-11 rounded-full
                          transition-all duration-300 ease-in-out
                          focus:outline-none
                          focus-visible:outline-none
                          focus-visible:ring-0
                          focus:ring-0
                          {{ navIconClass(request()->is('wishlist*')) }}">
                    
                    <span class="w-6 h-6">
                        @include('icons.heart')
                    </span>

                    @auth
                        @if($wishlistCount > 0)
                            <span class="absolute -top-1 -right-1 bg-[#930014] text-white text-[10px] px-1.5 rounded-full">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    @endauth
                </a>

                {{-- CART --}}
                <a href="/cart"
                   class="relative shrink-0 flex items-center justify-center w-11 h-11 rounded-full
                          transition-all duration-300 ease-in-out
                          focus:outline-none
                          focus-visible:outline-none
                          focus-visible:ring-0
                          focus:ring-0
                          {{ navIconClass(request()->is('cart*')) }}
                          [-webkit-tap-highlight-color:transparent]">

                    <span class="w-6 h-6">
                        @include('icons.cart')
                    </span>

                    @auth
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-[#930014] text-white text-[10px] px-1.5 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endauth
                </a>


                {{-- NOTIFICATION --}}
                <a href="/notifications" 
                   class="relative shrink-0 hidden md:flex items-center justify-center w-11 h-11 rounded-full
                          transition-all duration-300
                          focus:outline-none
                          focus-visible:outline-none
                          focus-visible:ring-0
                          focus:ring-0
                          {{ navIconClass(request()->is('notifications*')) }}">

                    <span class="w-6 h-6">
                        @include('icons.notification-icon')
                    </span>

                    @auth
                        @if($notifCount > 0)
                            <span class="absolute -top-2 -right-2 bg-[#930014] text-white text-xs px-1.5 rounded-full">
                                {{ $notifCount }}
                            </span>
                        @endif
                    @endauth
                </a>

                {{-- PROFILE DROPDOWN --}}
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button 
                            class="shrink-0 flex items-center gap-2 px-3 h-11 rounded-full
                                transition-all duration-300
                                focus:outline-none focus-visible:ring-0
                                {{ request()->routeIs('profile.*')
                                        ? 'bg-[#E68757]/20 text-[#930014]'
                                        : 'text-black hover:bg-[#E7BD8A]/30 hover:text-[#DB4B3A]' }}">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">
                                {{ Auth::user()->name }}
                            </span>
                            <div class="relative shrink-0 flex items-center justify-center w-8 h-12">
                                @include('icons.profile-icon')
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-black hover:bg-[#E7BD8A]/30 hover:text-[#DB4B3A]">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-[#930014] hover:bg-[#E7BD8A]/30 hover:text-[#DB4B3A]">
                                Logout
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
         x-transition
         @click.outside="open = false"
         class="md:hidden border-t border-[#E7BD8A] bg-white px-4 py-4 space-y-3">

        <a href="/category" class="flex items-center gap-3 p-2 rounded hover:bg-[#E7BD8A]/30">
            @include('icons.category-icon') Kategori
        </a>

        <a href="/wishlist" class="flex items-center gap-3 p-2 rounded hover:bg-[#E7BD8A]/30">
            @include('icons.heart') Wishlist
        </a>

        <a href="/notifications" class="flex items-center gap-3 p-2 rounded hover:bg-[#E7BD8A]/30">
            @include('icons.notification-icon') Notifikasi
        </a>
    </div>
</nav>