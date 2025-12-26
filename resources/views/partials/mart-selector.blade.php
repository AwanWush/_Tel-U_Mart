<div
    x-show="openMart"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
>
    <div
        @click.outside="openMart = false"
        class="bg-white rounded-2xl w-full max-w-md p-6 space-y-5 text-black"
    >
        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold">
                Pilih prioritas toko
            </h2>
            <button @click="openMart = false" class="text-gray-500 hover:text-black">
                ✕
            </button>
        </div>

        <p class="text-sm text-gray-600">
            Pilih toko untuk menentukan prioritas produk yang ditampilkan:
        </p>

        {{-- MART LIST --}}
        <div class="space-y-3">

            {{-- SEMUA MART --}}
            <form method="POST" action="{{ route('mart.select') }}">
                @csrf
                <input type="hidden" name="mart_id" value="">

                <button
                    class="w-full flex justify-between items-center
                           px-4 py-3 rounded-xl border
                           text-black hover:text-[#930014]
                           hover:bg-[#E7BD8A]/20 transition
                           {{ is_null($activeMart) ? 'border-[#930014] bg-[#E7BD8A]/30 font-bold' : '' }}"
                >
                    <span>Semua Mart</span>
                    <span class="text-xs text-gray-500">
                        {{ $totalProdukSemuaMart }} produk (total)
                    </span>
                </button>
            </form>

            @foreach($marts as $mart)
                <form method="POST" action="{{ route('mart.select') }}">
                    @csrf
                    <input type="hidden" name="mart_id" value="{{ $mart->id }}">

                    <button
                        class="w-full flex justify-between items-center
                               px-4 py-3 rounded-xl border
                               text-black hover:text-[#930014]
                               hover:bg-[#E7BD8A]/20 transition
                               {{ $activeMart?->id === $mart->id ? 'border-[#930014] bg-[#E7BD8A]/30 font-bold' : '' }}"
                    >
                        <span>{{ $mart->nama_mart }}</span>
                        <span class="text-xs text-gray-500">
                            {{ $mart->produk_count }} produk
                        </span>
                    </button>
                </form>
            @endforeach

        </div>
    </div>
</div>
