<div 
    x-data
    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-2"
>
    {{-- ONE UNIFIED BACKGROUND --}}
    <div class="bg-white rounded-3xl shadow border border-[#E7BD8A]/1 p-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

            {{-- ================= LEFT (SMALLER) ================= --}}
            <div class="flex flex-col justify-start h-full">

                {{-- Welcome --}}
                @auth
                    <div>
                        <h2 class="text-2xl font-bold text-[#5B000B]">
                            Selamat datang, {{ auth()->user()->name }} !
                        </h2>

                        <div class="mt-2 text-sm text-gray-500">
                            📍 {{ auth()->user()->gedung ?? 'Gedung belum diatur' }}
                            • Kamar {{ auth()->user()->kamar ?? '-' }}
                        </div>

                        <p class="mt-3 text-gray-600 leading-relaxed">
                            Temukan kebutuhan harian asramamu dengan 
                            cepat, praktis, dan aman langsung dari mart asrama.
                        </p>

                    </div>
                @endauth

                {{-- MAIN FEATURES --}}
                <div class="mt-3 grid grid-cols-2 lg:grid-cols-1 gap-3">

                    {{-- Token --}}
                    <a href="{{ route('token.index') }}"
                    class="group flex items-center gap-4 p-5 rounded-xl
                        bg-gradient-to-r from-[#DB4B3A]/90 to-[#930014]
                        hover:brightness-110 transition">


                        {{-- ICON --}}
                        <div
                            class="w-12 h-12 aspect-square
                                flex items-center justify-center
                                bg-white rounded-lg shadow
                                text-[#5B000B]"
                        >
                            @include('icons.electricity')
                        </div>


                        <div>
                            <h3 class="font-semibold text-[#E7BD8A] group-hover:text-white">
                                Token Listrik
                            </h3>
                            <p class="text-sm text-[#E7BD8A] group-hover:text-white/90">
                                Isi token Listrik kapan saja
                            </p>
                        </div>
                    </a>

                    {{-- Galon --}}
                    <a href="{{ route('galon.index') }}"
                    class="group flex items-center gap-4 p-5 rounded-xl
                        bg-gradient-to-r from-[#5B000B]/90 to-[#930014]
                        hover:brightness-110 transition">


                        {{-- ICON --}}
                        <div
                            class="w-12 h-12 aspect-square
                                flex items-center justify-center
                                bg-white rounded-lg shadow
                                text-[#5B000B]"
                        >
                            @include('icons.gallon')
                        </div>

                        <div>
                            <h3 class="font-semibold text-[#E7BD8A] group-hover:text-white">
                                Galon Asrama
                            </h3>
                            <p class="text-sm text-[#E7BD8A] group-hover:text-white/90">
                                Air bersih langsung diantar
                            </p>
                        </div>
                    </a>

                </div>
            </div>

            {{-- ================= RIGHT (BIGGER) ================= --}}
            @php
                /**
                * Bagi produk terbaru menjadi 2 grup
                * - Total 8 produk
                * - Tiap grup isi 4 (2 atas, 2 bawah)
                */
                $groups = collect($latestProducts)->chunk(4);
            @endphp
            <div
                class="lg:col-span-2 flex flex-col relative h-full"
                x-data="{
                    openGroup: null,
                    hoverTimer: null,

                    startHover(group) {
                        this.clearHover()
                        this.hoverTimer = setTimeout(() => {
                            this.openGroup = group
                        }, 500)
                    },

                    clearHover() {
                        if (this.hoverTimer) {
                            clearTimeout(this.hoverTimer)
                            this.hoverTimer = null
                        }
                    },

                    closePopup() {
                        this.clearHover()
                        this.openGroup = null
                    }
                }"
            >
                <h3 class="text-xl font-bold text-[#5B000B] mb-4">
                    Produk Terbaru
                </h3>

                {{-- DESKTOP --}}
                <div class="hidden lg:grid grid-cols-2 gap-4 flex-1 h-full">

                    @foreach($groups as $groupIndex => $group)
                        <div class="grid grid-cols-2 grid-rows-2 gap-3 h-full">

                            @foreach($group as $product)
                                <a href="{{ route('produk.show', $product->id) }}"
                                   class="group relative rounded-xl overflow-hidden border border-[#DB4B3A]/10 transition hover:shadow-lg">

                                    <div class="w-full h-full">
                                        <img
                                            src="{{ asset($product->gambar) }}"
                                            alt="{{ $product->nama_produk }}"
                                            class="w-full h-full object-cover
                                                transition-transform duration-300 ease-out
                                                group-hover:scale-105"
                                        />
                                    </div>

                                    <div class="absolute bottom-3 left-3 right-3"> 
                                        <div class="bg-[#DB4B3A]/80 text-white text-sm px-3 py-1 rounded-md"> 
                                            {{ $product->nama_produk }} 
                                        </div> 
                                    </div>

                                </a>
                            @endforeach

                        </div>
                    @endforeach

                </div>

                {{-- MOBILE --}}
                <div class="lg:hidden flex gap-4 overflow-x-auto pb-2">

                    @foreach($groups as $groupIndex => $group)
                        <div
                            class="min-w-[160px] grid grid-cols-2 grid-rows-2 gap-2 cursor-pointer group"
                            @mouseenter="startHover({{ $groupIndex }})"
                            @mouseleave="clearHover()"
                            @touchstart="startHover({{ $groupIndex }})"
                        >
                            @foreach($group as $product)
                                <div class="aspect-square overflow-hidden rounded-lg border border-[#DB4B3A]/10">
                                    <a href="{{ route('produk.show', $product->id) }}"
                                        class="group relative rounded-xl overflow-hidden border border-[#DB4B3A]/10">
                                        <img
                                            src="{{ asset($product->gambar) }}"
                                            alt="{{ $product->nama_produk }}"
                                            class="w-full h-full object-cover
                                                transition-transform duration-300 ease-out
                                                group-hover:scale-105"
                                        />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>

                {{-- MOBILE POPUP --}}
                <div
                    x-show="openGroup !== null"
                    x-transition.opacity
                    class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center"
                    @click.self="closePopup()"
                >
                    <div
                        class="bg-white rounded-2xl w-[90%] max-w-sm
                            relative pt-10 px-4 pb-4
                            transform transition-all duration-300"
                        x-transition:enter="ease-out scale-95 opacity-0"
                        x-transition:enter-end="scale-100 opacity-100"
                        x-transition:leave="ease-in scale-100 opacity-100"
                        x-transition:leave-end="scale-95 opacity-0"
                    >

                        {{-- CLOSE BUTTON --}}
                        <button
                            @click="openGroup = null"
                            class="absolute top-3 right-3
                                w-8 h-8 rounded-full
                                flex items-center justify-center
                                text-gray-500 hover:text-[#930014]
                                hover:bg-gray-100 transition"
                            aria-label="Tutup"
                        >
                            ✕
                        </button>

                        {{-- CONTENT --}}
                        <div class="grid grid-cols-2 gap-3">

                            @foreach($groups as $groupIndex => $group)
                                <template x-if="openGroup === {{ $groupIndex }}">
                                    <div class="contents">
                                        @foreach($group as $product)
                                            <a href="{{ route('produk.show', $product->id) }}"
                                            class="group relative rounded-xl overflow-hidden
                                                    border border-[#DB4B3A]/10">

                                                <div class="aspect-square">
                                                    <img
                                                        src="{{ asset($product->gambar) }}"
                                                        alt="{{ $product->nama_produk }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>

                                                <div class="absolute bottom-3 left-3 right-3">
                                                    <div class="bg-[#DB4B3A]/80 text-white
                                                                text-sm px-3 py-1 rounded-md
                                                                text-center">
                                                        {{ $product->nama_produk }}
                                                    </div>
                                                </div>

                                            </a>
                                        @endforeach
                                    </div>
                                </template>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
