<x-app-layout>

<style>
    .form-field { color: #000 !important; }
    .transition-all { transition: all 0.3s ease; }
    .method-card {
        border: 2px solid #e5e7eb;
        transition: all 0.2s;
    }
    .method-active {
        border-color: #2563eb !important;
        background-color: #eff6ff !important;
    }
    [x-cloak] { display: none !important; }
</style>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Beli Galon') }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
         x-data="{ 
            hasGalon: false, 
            pilihanGalon: '',
            hargaSatuan: 0,
            jumlah: 1,
            step: 1,
            metode: 'cod',
            get totalHarga() { return this.hargaSatuan * this.jumlah }
         }">

        {{-- Tombol Riwayat --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('galon.history') }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Pembelian
            </a>
        </div>

        {{-- Informasi Pengguna --}}
        <div class="bg-gradient-to-r from-gray-800 to-gray-700 p-6 rounded-2xl mb-8 text-white shadow-xl border border-gray-600">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-500/20 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold tracking-tight">Informasi Penghuni</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-900/30 p-3 rounded-xl border border-white/5">
                    <p class="text-blue-300 text-xs uppercase font-black mb-1">Nama Lengkap</p>
                    <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                </div>
                <div class="bg-gray-900/30 p-3 rounded-xl border border-white/5">
                    <p class="text-blue-300 text-xs uppercase font-black mb-1">Gedung Asrama</p>
                    <p class="font-bold text-lg">{{ Auth::user()->lokasi->nama_lokasi ?? Auth::user()->alamat_gedung ?? '-' }}</p>
                </div>
                <div class="bg-gray-900/30 p-3 rounded-xl border border-white/5">
                    <p class="text-blue-300 text-xs uppercase font-black mb-1">Nomor Kamar</p>
                    <p class="font-bold text-lg">{{ Auth::user()->nomor_kamar ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Form Pemesanan --}}
        <div class="bg-white dark:bg-gray-800 shadow-2xl sm:rounded-3xl p-8 border border-gray-100 dark:border-gray-700">
            
            {{-- STEP 1: FORM DATA --}}
            <div x-show="step === 1">
                <div class="flex items-center mb-8">
                    <div class="w-2 h-8 bg-blue-600 rounded-full mr-4"></div>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white">Pesan Galon</h3>
                </div>

                <div class="space-y-6">
                    <div class="p-5 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-500/30 rounded-2xl">
                        <label class="block text-blue-900 dark:text-blue-200 mb-4 font-black text-lg">
                            Apakah Anda sudah memiliki botol galon kosong di kamar?
                        </label>
                        <div class="flex flex-col sm:flex-row gap-6">
                            <label class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl cursor-pointer hover:border-blue-500 transition-all flex-1 shadow-sm border border-gray-200">
                                <input type="radio" name="check_galon" @click="hasGalon = true" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 font-bold text-gray-700 dark:text-gray-200">Ya, Sudah Ada</span>
                            </label>
                            <label class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl cursor-pointer hover:border-blue-500 transition-all flex-1 shadow-sm border border-gray-200">
                                <input type="radio" name="check_galon" @click="hasGalon = false; pilihanGalon = ''" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                <span class="ml-3 font-bold text-gray-700 dark:text-gray-200">Belum Ada</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jenis Galon</label>
                        <select id="galonSelect" x-model="pilihanGalon"
                            @change="const g = galons.find(x => x.nama === $el.value); hargaSatuan = g ? g.harga : 0"
                            class="form-field w-full rounded-xl bg-gray-50 border-gray-300 focus:ring-4 focus:ring-blue-500/20 p-3.5 font-bold shadow-sm">
                            <option value="" disabled selected>-- Pilih Paket Galon --</option>
                            @foreach($galons as $g)
                                @php $isIsiUlang = str_contains(strtolower($g['nama']), 'isi ulang'); @endphp
                                <option value="{{ $g['nama'] }}" 
                                        x-show="{{ $isIsiUlang ? 'hasGalon' : 'true' }}"
                                        :disabled="{{ $isIsiUlang ? '!hasGalon' : 'false' }}">
                                    {{ $g['nama'] }} - Rp{{ number_format($g['harga'],0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jumlah Pesanan</label>
                        <input type="number" id="jumlahInput" x-model="jumlah" min="1"
                               class="form-field w-full rounded-xl bg-gray-50 border-gray-300 p-3.5 font-bold shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Catatan Tambahan</label>
                        <textarea id="catatanInput" rows="3" placeholder="Contoh: Titip di depan pintu kamar..."
                                  class="form-field w-full rounded-xl bg-gray-50 border-gray-300 p-3.5 font-bold shadow-sm"></textarea>
                    </div>

                    <button type="button" @click="if(pilihanGalon) step = 2"
                            :disabled="!pilihanGalon"
                            class="w-full py-4 bg-blue-600 rounded-2xl font-black text-lg text-white uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl disabled:opacity-50">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </div>

            {{-- STEP 2: METODE PEMBAYARAN --}}
            <div x-show="step === 2" x-cloak>
                <button @click="step = 1" class="text-blue-600 font-bold flex items-center mb-6 hover:underline">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Form
                </button>

                <h3 class="text-2xl font-black text-gray-900 mb-8 uppercase tracking-tighter dark:text-white">Pilih Metode Pembayaran</h3>

                <div class="space-y-4 mb-8">
                    <div class="method-card p-5 rounded-2xl cursor-pointer" 
                         :class="metode === 'cod' ? 'method-active' : ''"
                         @click="metode = 'cod'">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-money-bill-wave text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Bayar di Tempat (COD)</p>
                                    <p class="text-xs text-gray-500">Bayar tunai saat galon diantar</p>
                                </div>
                            </div>
                            <div x-show="metode === 'cod'" class="text-blue-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="method-card p-5 rounded-2xl cursor-pointer" 
                         :class="metode === 'midtrans' ? 'method-active' : ''"
                         @click="metode = 'midtrans'">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-university text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Pembayaran Online</p>
                                    <p class="text-xs text-gray-500">Transfer Bank, QRIS, GoPay (via Midtrans)</p>
                                </div>
                            </div>
                            <div x-show="metode === 'midtrans'" class="text-blue-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-8">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Total Harga (<span x-text="jumlah"></span>x)</span>
                        <span class="font-bold text-gray-900" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between pt-4 border-t border-gray-200">
                        <span class="font-black text-gray-900 text-lg uppercase">Total Tagihan</span>
                        <span class="font-black text-blue-600 text-2xl" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></span>
                    </div>
                </div>

                <button id="btnFinalOrder" @click="handleOrder($data)"
                        class="w-full py-4 bg-blue-600 rounded-2xl font-black text-lg text-white uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl">
                    Buat Pesanan Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Form untuk COD --}}
<form id="realForm" action="{{ route('galon.store') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="nama_galon">
    <input type="hidden" name="jumlah">
    <input type="hidden" name="catatan">
    <input type="hidden" name="harga_satuan">
    <input type="hidden" name="metode_pembayaran" value="COD">
</form>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script>
    const galons = @json($galons);

    async function handleOrder(alpineData) {
        const btn = document.getElementById('btnFinalOrder');
        const catatanValue = document.getElementById('catatanInput').value;

        if (alpineData.metode === 'cod') {
            // LOGIKA COD
            const form = document.getElementById('realForm');
            form.querySelector('[name=nama_galon]').value = alpineData.pilihanGalon;
            form.querySelector('[name=jumlah]').value = alpineData.jumlah;
            form.querySelector('[name=catatan]').value = catatanValue;
            form.querySelector('[name=harga_satuan]').value = alpineData.hargaSatuan;
            form.submit();
        } else {
            // LOGIKA MIDTRANS
            btn.disabled = true;
            btn.innerText = 'MEMPROSES...';
            
            try {
                const response = await fetch("{{ route('payment.snap-token') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        total_amount: alpineData.totalHarga,
                        type: 'galon',
                        product_name: alpineData.pilihanGalon
                    })
                });

                const midData = await response.json();

                window.snap.pay(midData.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = `/order/success?status=paid&amount=${alpineData.totalHarga}&type=galon&order_id=${midData.order_id}&nama_galon=${alpineData.pilihanGalon}&jumlah=${alpineData.jumlah}`;
                    },
                    onPending: function(result) {
                        window.location.href = `/order/success?status=pending&amount=${alpineData.totalHarga}&type=galon&order_id=${midData.order_id}`;
                    },
                    onClose: function() {
                        btn.disabled = false;
                        btn.innerText = 'Buat Pesanan Sekarang';
                    }
                });
            } catch (e) {
                alert('Gagal memproses pembayaran online.');
                btn.disabled = false;
                btn.innerText = 'Buat Pesanan Sekarang';
            }
        }
    }
</script>

</x-app-layout>