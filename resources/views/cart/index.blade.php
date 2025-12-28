<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keranjang Kamu 🛒
        </h2>
    </x-slot>

    <div class="py-0 bg-gray-100 min-h-screen" x-data="{
        items: [
            @foreach ($cartItems as $item)
            {
                id: {{ $item->id }},
                price: {{ $item->produk->harga }},
                qty: {{ $item->quantity }},
                selected: true
            }, @endforeach
        ],
        selectAll: true,

        updateQty(id, newQty) {
            fetch(`/cart/update/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal update database');
                console.log('Database updated');
            })
            .catch(error => console.error('Error:', error));
        },

        toggleAll() {
            this.selectAll = !this.selectAll;
            this.items.forEach(i => i.selected = this.selectAll);
        },

        get totalSelected() {
            return this.items.filter(i => i.selected).reduce((sum, i) => sum + (i.price * i.qty), 0);
        },

        get countSelected() {
            return this.items.filter(i => i.selected).length;
        },

        formatRupiah(num) {
            return 'Rp ' + num.toLocaleString('id-ID');
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

            <div class="lg:col-span-2 space-y-3">

                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-100 flex justify-between items-center">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" @click="toggleAll()" :checked="selectAll"
                            class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer">
                        <span class="text-sm font-semibold text-gray-700">Pilih Semua</span>
                    </label>
                    <div class="text-right">
                        <p class="text-[9px] text-gray-400 uppercase font-bold tracking-tighter leading-none">WAKTU AKSES</p>
                        <p class="text-[11px] font-medium text-gray-600">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div> 
 
                @if ($cartItems->isEmpty())
                    <div class="bg-white py-12 text-center rounded-xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Keranjang kosong 🛒</h3>
                        <a href="{{ route('dashboard') }}" class="text-red-600 text-sm font-bold hover:underline">
                            Mulai Belanja Sekarang 
                        </a>
                    </div>
                @else
                    @foreach ($cartItems as $item)
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 transition-all hover:border-red-100">
                            <input type="checkbox" x-model="items.find(i => i.id === {{ $item->id }}).selected"
                                class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer">

                            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                                <img src="{{ asset('produk_assets/' . basename($item->produk->gambar)) }}"
                                    class="w-full h-full object-contain p-1"
                                    onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-800 text-sm truncate">{{ $item->produk->nama_produk }}</h4>
                                <p class="text-[10px] text-gray-400 font-medium">Stok: {{ $item->produk->stok }}</p>
                                <p class="text-sm font-black text-gray-900 mt-0.5">
                                    Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="flex flex-col items-center">
                                    <input type="number" min="1" max="{{ $item->produk->stok }}"
                                        x-model.number="items.find(i => i.id === {{ $item->id }}).qty"
                                        @change="updateQty({{ $item->id }}, $event.target.value)"
                                        class="w-12 h-8 border-gray-200 rounded text-center text-xs focus:ring-red-500 p-0">
                                    <span class="text-[8px] text-gray-400 mt-0.5 uppercase font-bold">Jumlah</span>
                                </div>

                                <div class="text-right min-w-[80px]">
                                    <span class="text-[8px] text-gray-400 block uppercase leading-none font-bold">Subtotal</span>
                                    <strong class="text-red-600 text-xs font-black"
                                        x-text="formatRupiah(items.find(i => i.id === {{ $item->id }}).qty * {{ $item->produk->harga }})">
                                    </strong>
                                </div>

                                <form method="POST" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 sticky top-[5.5rem] z-10 self-start">
                    <h3 class="font-bold text-sm text-gray-800 mb-4 border-b pb-2 uppercase tracking-tight">Ringkasan Belanja</h3>

                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-500 text-[11px] font-medium">
                            <span>Total Harga (<span x-text="countSelected"></span> barang)</span>
                            <span x-text="formatRupiah(totalSelected)"></span>
                        </div>
                        <div class="flex justify-between text-gray-500 text-[11px] font-medium">
                            <span>Biaya Layanan</span>
                            <span class="text-green-600 font-bold">Gratis</span>
                        </div>

                        <div class="pt-3 border-t border-gray-100 mt-2">
                            <div class="flex justify-between items-center mb-5">
                                <span class="font-bold text-xs text-gray-800">Total Tagihan</span>
                                <span class="text-base font-black text-red-600" x-text="formatRupiah(totalSelected)"></span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('checkout.selected') }}">
                        @csrf
                        <template x-for="item in items.filter(i => i.selected)" :key="item.id">
                            <input type="hidden" name="cart_items[]" :value="item.id">
                        </template>

                        <button type="submit" :disabled="countSelected === 0"
                            :class="countSelected === 0 ? 'bg-gray-200 text-gray-400 cursor-not-allowed' :
                                'bg-red-600 hover:bg-red-700 text-white shadow-md shadow-red-200'"
                            class="w-full py-2.5 rounded-lg font-bold text-xs transition-all duration-300 uppercase tracking-wider">
                            Checkout <span x-show="countSelected > 0" x-text="'(' + countSelected + ')'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>