<div 
    x-data
    class="max-w-7xl mx-auto px-4 py-8"
>
    {{-- ONE UNIFIED BACKGROUND --}}
    <div class="bg-white rounded-3xl shadow border border-[#E7BD8A]/1 p-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

            {{-- ================= LEFT (SMALLER) ================= --}}
            <div class="flex flex-col justify-between">

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
                <div class="mt-6 grid grid-cols-2 lg:grid-cols-1 gap-4">

                    {{-- Token --}}
                    <a href="{{ route('token.index') }}"
                    class="group flex items-center gap-4 p-5 rounded-xl
                            bg-[#E7BD8A]/30 
                            hover:bg-gradient-to-r from-[#5B000B]/70 via-[#930014] to-[#DB4B3A] transition">

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
                            <h3 class="font-semibold text-[#5B000B] group-hover:text-white">
                                Token Listrik
                            </h3>
                            <p class="text-sm text-gray-600 group-hover:text-white/90">
                                Isi token Listrik kapan saja
                            </p>
                        </div>
                    </a>

                    {{-- Galon --}}
                    <a href="{{ route('galon.index') }}"
                    class="group flex items-center gap-4 p-5 rounded-xl
                            bg-[#E7BD8A]/30
                            hover:bg-gradient-to-r from-[#5B000B]/70 via-[#930014] to-[#DB4B3A] transition">

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
                            <h3 class="font-semibold text-[#5B000B] group-hover:text-white">
                                Galon Asrama
                            </h3>
                            <p class="text-sm text-gray-600 group-hover:text-white/90">
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
            <div class="lg:col-span-2 flex flex-col relative"
                x-data="{ openGroup: null }">

                <h3 class="text-xl font-bold text-[#5B000B] mb-4">
                    Produk Terbaru
                </h3>

                {{-- DESKTOP --}}
                <div class="hidden lg:grid grid-cols-2 gap-4 flex-1 items-stretch">

                    @foreach($groups as $groupIndex => $group)
                        <div class="grid grid-cols-2 grid-rows-2 gap-3 h-full">

                            @foreach($group as $product)
                                <a href="{{ route('produk.show', $product->id) }}"
                                class="relative rounded-xl overflow-hidden border border-[#DB4B3A]/10">

                                    <div class="aspect-square w-full h-full">
                                        <img
                                            src="{{ asset($product->gambar) }}"
                                            alt="{{ $product->nama_produk }}"
                                            class="w-full h-full object-cover hover:scale-105 transition"
                                        >
                                    </div>

                                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2">
                                        <div class="bg-[#DB4B3A]/80 text-white text-sm px-3 py-1 rounded-md text-center">
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
                            class="min-w-[160px] grid grid-cols-2 grid-rows-2 gap-2 cursor-pointer"
                            @click="openGroup = {{ $groupIndex }}"
                        >
                            @foreach($group as $product)
                                <div class="aspect-square overflow-hidden rounded-lg border border-[#DB4B3A]/10">
                                    <img
                                        src="{{ asset($product->gambar) }}"
                                        alt="{{ $product->nama_produk }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>

                {{-- MOBILE POPUP --}}
                <div
                    x-show="openGroup !== null"
                    x-transition
                    class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center"
                >
                    <div class="bg-white rounded-2xl p-4 w-[90%] max-w-sm">

                        <button
                            class="text-sm text-gray-500 mb-3"
                            @click="openGroup = null"
                        >
                            Tutup
                        </button>

                        <div class="grid grid-cols-2 gap-3">
                            <template x-for="product in {{ $latestProducts->values() }}">
                                <div></div>
                            </template>

                            @foreach($groups as $groupIndex => $group)
                                <template x-if="openGroup === {{ $groupIndex }}">
                                    <div class="contents">
                                        @foreach($group as $product)
                                            <a href="{{ route('produk.show', $product->id) }}"
                                            class="relative rounded-xl overflow-hidden border border-[#DB4B3A]/10">

                                                <div class="aspect-square">
                                                    <img
                                                        src="{{ asset($product->gambar) }}"
                                                        alt="{{ $product->nama_produk }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>

                                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2">
                                                    <div class="bg-[#DB4B3A]/80 text-white text-xs px-2 py-1 rounded text-center">
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
