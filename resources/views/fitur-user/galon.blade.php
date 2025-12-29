<x-app-layout>

<style>
    /* Tombol Solid (Lanjut & Konfirmasi) */
    .btn-solid-custom {
        background-color: #930014 !important;
        color: #ffffff !important;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-solid-custom:hover {
        background-color: #5B000B !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Tombol Outline (Riwayat) */
    .btn-outline-custom {
        background-color: white !important;
        color: #930014 !important;
        border: 1px solid #E7BD8A !important;
        transition: all 0.3s ease;
    }
    .btn-outline-custom:hover {
        background-color: #930014 !important;
        color: white !important;
        border-color: #930014 !important;
    }

    /* Animasi Hover untuk Kartu Metode Pembayaran */
    .payment-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .form-input-custom {
        border: 1px solid #E7BD8A !important;
        border-radius: 0.75rem !important;
        padding: 1rem !important;
        width: 100%;
        background-color: white !important;
    }
</style>

<x-slot name="header">
    <h2 class="font-light text-2xl text-[#5B000B] leading-tight">
        {{ __('Beli Galon') }}
    </h2>
</x-slot>

<div class="py-12 bg-[#F9F9F9] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" 
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
               class="btn-outline-custom inline-flex items-center px-6 py-2.5 rounded-full font-semibold text-xs uppercase tracking-widest shadow-sm">
                <i class="far fa-clock mr-2"></i>
                Riwayat Pembelian
            </a>
        </div>

        {{-- BOX INFORMASI PENGHUNI --}}
        <div class="bg-white p-8 rounded-[2rem] mb-10 border border-[#E7BD8A]/30 shadow-sm text-[#5B000B]">
            <div class="flex items-center mb-8 border-b border-gray-100 pb-4">
                <i class="fas fa-user-circle mr-3 text-[#930014] text-xl"></i>
                <h3 class="text-sm font-black uppercase tracking-widest">Informasi Penghuni</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div>
                    <p class="text-[#E68757] text-[10px] uppercase font-black mb-1 tracking-widest">Nama Lengkap</p>
                    <p class="text-base font-semibold">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-[#E68757] text-[10px] uppercase font-black mb-1 tracking-widest">Gedung Asrama</p>
                    <p class="text-base font-semibold">{{ Auth::user()->lokasi->nama_lokasi ?? Auth::user()->alamat_gedung ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[#E68757] text-[10px] uppercase font-black mb-1 tracking-widest">Nomor Kamar</p>
                    <p class="text-base font-semibold">{{ Auth::user()->nomor_kamar ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- CARD UTAMA PEMESANAN --}}
        <div class="bg-white shadow-xl rounded-[2.5rem] p-10 md:p-14 border border-[#E7BD8A]/20">
            
            {{-- STEP 1 --}}
            <div x-show="step === 1" class="space-y-12">
                <div>
                    <h3 class="text-3xl font-light text-[#5B000B]">Pemesanan Galon</h3>
                    <div class="h-1 w-12 bg-[#E7BD8A] mt-4 rounded-full"></div>
                </div>

                <div class="space-y-6">
                    <label class="block text-[#5B000B] font-bold text-lg">
                        Apakah Anda sudah memiliki botol galon kosong di kamar?
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label @click="hasGalon = true" class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-sm"
                               :class="hasGalon ? 'border-[#930014] bg-[#930014]/5' : 'border-gray-100 bg-white hover:border-[#E7BD8A]'">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 mr-4">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="font-bold text-gray-700">Ya, Sudah Ada</span>
                        </label>
                        <label @click="hasGalon = false; pilihanGalon = ''" class="payment-card flex items-center p-6 rounded-2xl cursor-pointer border-2 transition-all shadow-sm"
                               :class="!hasGalon ? 'border-[#930014] bg-[#930014]/5' : 'border-gray-100 bg-white hover:border-[#E7BD8A]'">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-red-50 text-red-600 mr-4">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <span class="font-bold text-gray-700">Belum Ada</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-[#E68757] uppercase tracking-[0.2em]">Jenis Galon</label>
                        <select x-model="pilihanGalon"
                                @change="const g = galons.find(x => x.nama === $el.value); hargaSatuan = g ? g.harga : 0"
                                class="form-input-custom focus:ring-[#930014] focus:border-[#930014]">
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

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-[#E68757] uppercase tracking-[0.2em]">Jumlah Pesanan</label>
                        <input type="number" x-model="jumlah" min="1"
                               class="form-input-custom focus:ring-[#930014] focus:border-[#930014]">
                    </div>

                    <div class="space-y-3 md:col-span-2">
                        <label class="text-[10px] font-black text-[#E68757] uppercase tracking-[0.2em]">
                            Catatan Tambahan
                        </label>
                        <textarea id="catatanInput"
                            class="form-input-custom"
                            rows="3"
                            placeholder="Contoh: titip di depan kamar"></textarea>
                    </div>

                </div>
                <button type="button" @click="if(pilihanGalon) step = 2"
                        :disabled="!pilihanGalon"
                        class="btn-solid-custom w-full py-5 rounded-2xl font-bold uppercase tracking-[0.2em] shadow-lg disabled:opacity-30">
                    Lanjut ke Pembayaran
                </button>
            </div>

            {{-- STEP 2 (Metode Pembayaran) --}}
            <div x-show="step === 2" x-cloak class="space-y-10">
                {{-- Tombol Kembali (Warna merah solid, Tanpa Hover) --}}
                <button @click="step = 1" class="text-[#930014] text-xs font-black flex items-center cursor-pointer">
                    <i class="fas fa-arrow-left mr-2"></i>
                    KEMBALI KE PEMILIHAN
                </button>

                <h3 class="text-xl font-bold text-[#5B000B] uppercase tracking-widest">Metode Pembayaran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div @click="metode = 'cod'" 
                         class="payment-card p-8 rounded-3xl cursor-pointer border-2 transition-all bg-white text-center flex flex-col items-center justify-center group"
                         :class="metode === 'cod' ? 'border-[#930014] bg-[#930014]/5' : 'border-gray-100'">
                        <div class="mb-4 w-16 h-16 flex items-center justify-center rounded-2xl bg-[#930014]/10 text-[#930014] group-hover:scale-110 transition-transform">
                            <i class="fas fa-hand-holding-usd text-3xl"></i>
                        </div>
                        <p class="font-black text-[#5B000B] text-lg">COD</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest">Bayar di Tempat</p>
                    </div>

                    <div @click="metode = 'midtrans'" 
                         class="payment-card p-8 rounded-3xl cursor-pointer border-2 transition-all bg-white text-center flex flex-col items-center justify-center group"
                         :class="metode === 'midtrans' ? 'border-[#930014] bg-[#930014]/5' : 'border-gray-100'">
                        <div class="mb-4 w-16 h-16 flex items-center justify-center rounded-2xl bg-[#930014]/10 text-[#930014] group-hover:scale-110 transition-transform">
                            <i class="fas fa-credit-card text-3xl"></i>
                        </div>
                        <p class="font-black text-[#5B000B] text-lg">Online</p>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest">QRIS / Transfer</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-[#5B000B] uppercase tracking-widest text-sm">Total Pembayaran (<span x-text="jumlah"></span>x)</span>
                        <span class="font-black text-[#930014] text-3xl" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></span>
                </div>

                <button id="btnFinalOrder" @click="handleOrder($data)"
                        class="btn-solid-custom w-full py-5 rounded-2xl font-bold uppercase tracking-[0.2em] shadow-xl text-lg">
                    Konfirmasi & Pesan
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