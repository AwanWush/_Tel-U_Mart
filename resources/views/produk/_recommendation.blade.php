<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    @forelse ($produk as $item)
        <div
            x-data="{ hover: false }"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
            class="group relative bg-white rounded-2xl
                   border border-black/5
                   hover:border-[#E68757]
                   hover:shadow-lg
                   transition overflow-hidden"
        >
            <a href="{{ route('produk.show', $item) }}" class="block p-3">

                {{-- IMAGE --}}
                <div class="relative rounded-xl overflow-hidden bg-white">
                    <img
                        src="{{ asset(str_replace('produk/', 'produk_assets/', $item->gambar)) }}"
                        class="w-full h-40 object-contain
                               transition-transform duration-300
                               group-hover:scale-105"
                    />

                    @if($item->persentase_diskon)
                        <span
                            class="absolute top-2 left-2
                                   text-xs font-bold
                                   bg-[#DB4B3A] text-white
                                   px-2 py-0.5 rounded-full">
                            -{{ $item->persentase_diskon }}%
                        </span>
                    @endif
                </div>

                {{-- NAMA --}}
                <h3 class="mt-3 text-sm font-medium text-black line-clamp-2 min-h-[36px]">
                    {{ $item->nama_produk }}
                </h3>

                {{-- HARGA --}}
                <div class="mt-1 text-base font-semibold text-[#930014]">
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                </div>

                {{-- STOK --}}
                <div class="mt-1 text-xs font-semibold flex items-center gap-1
                    {{ $item->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                    <span class="uppercase tracking-wide">Stok:</span>
                    <span class="text-sm">{{ $item->stok }}</span>
                </div>

                {{-- LOKASI / MART --}}
                <div class="mt-1 text-xs text-black/60 leading-snug">
                    Lokasi:
                    <div>
                        @foreach ($item->highlightedMarts() as $mart)
                            <span class="
                                {{ $mart['is_active']
                                    ? 'text-[#930014] font-semibold'
                                    : 'text-black/50'
                                }}">
                                {{ $mart['nama'] }}
                            </span>@if(!$loop->last), @endif
                        @endforeach
                    </div>
                </div>
            </a>

            {{-- ACTION BUTTON --}}
            <div
                x-show="hover"
                x-transition.opacity
                class="absolute top-3 right-3 flex flex-col gap-2"
            >
                {{-- Wishlist --}}
                <form action="{{ route('wishlist.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                    <button type="submit"
                        class="w-9 h-9 rounded-full
                               bg-[#E7BD8A]/80 hover:bg-[#E68757]
                               border border-[#930014]/30
                               flex items-center justify-center
                               text-[#930014] hover:text-white
                               transition">
                        @include('icons.heart')
                    </button>
                </form>

                {{-- Cart --}}
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                    <button type="submit"
                        class="w-9 h-9 rounded-full
                               bg-[#DB4B3A] hover:bg-[#930014]
                               border border-[#930014]
                               flex items-center justify-center
                               text-white transition">
                        @include('icons.cart')
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="col-span-full text-sm text-gray-500 italic">
            Tidak ada produk rekomendasi.
        </p>
    @endforelse
</div>