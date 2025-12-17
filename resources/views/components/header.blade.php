<header class="fixed top-0 left-0 w-full bg-white shadow z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center p-4">

        {{-- Logo sementara --}}
        <a href="/" class="text-2xl font-bold">TJ&TMart</a>

        {{-- Kategori --}}
        <a href="/category" class="text-1xl font-bold">Category</a>

        {{-- Search Bar --}}
        <form action="/search" method="GET" class="w-1/2">
            <input  type="text" 
                    name="q" 
                    class="w-full px-4 py-2 border rounded"
                    placeholder="Cari produk di TJ&TMart"
            >
        </form>

        {{-- Tombol Ikon: Notifikasi, Wishlist, Keranjang, Profile --}}
        <div class="flex gap-6 items-center">

            {{-- Wishlist Icon --}}
            <a  href="/wishlist" 
                class="relative"
            >
                @include('icons.heart')
                @auth
                    @if($wishlistCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1">
                            {{ $wishlistCount }}
                        </span>
                    @endif
                @endauth
            </a>

            {{-- Cart Icon --}}
            <a  href="/cart" 
                class="relative"
            >
                @include('icons.cart')
                @auth
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-1">
                            {{ $cartCount }}
                        </span>
                    @endif
                @endauth
            </a>

            {{-- Notification Icon --}}
            <a  href="/notifications" 
                class="relative"
            >
                @include('icons.notification-icon')
                @auth
                    @if($notifCount > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-1">
                            {{ $notifCount }}
                        </span>
                    @endif
                @endauth
            </a>

            {{-- Profile Icon --}}
            @auth
                <a href="/profile">
                    @include('icons.profile-icon')
                </a>
            @endauth

        </div>
    </div>
</header>