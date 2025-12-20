<x-app-layout>

<style>
    /* Hanya teks di dalam input, select, textarea yang hitam */
    .form-field {
        color: #000 !important;
    }
    /* Efek transisi halus untuk hover */
    .transition-all {
        transition: all 0.3s ease;
    }
</style>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Beli Galon') }}
    </h2>
</x-slot>

<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Tombol Riwayat --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('galon.history') }}"
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition-all shadow-lg shadow-blue-500/30">
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

        {{-- Form Pemesanan dengan Alpine.js --}}
        <div class="bg-white dark:bg-gray-800 shadow-2xl sm:rounded-3xl p-8 border border-gray-100 dark:border-gray-700" 
             x-data="{ 
                hasGalon: false, 
                pilihanGalon: '' 
             }">

            <div class="flex items-center mb-8">
                <div class="w-2 h-8 bg-blue-600 rounded-full mr-4"></div>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">Pesan Galon</h3>
            </div>

            <form action="{{ route('galon.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Pertanyaan Awal: Cek Kepemilikan Galon --}}
                <div class="p-5 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-500/30 rounded-2xl transition-all">
                    <label class="block text-blue-900 dark:text-blue-200 mb-4 font-black text-lg">
                        Apakah Anda sudah memiliki botol galon kosong di kamar?
                    </label>
                    <div class="flex flex-col sm:flex-row gap-6">
                        <label class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 transition-all flex-1 shadow-sm">
                            <input type="radio" name="check_galon" @click="hasGalon = true" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-3 font-bold text-gray-700 dark:text-gray-200">Ya, Sudah Ada</span>
                        </label>
                        <label class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 transition-all flex-1 shadow-sm">
                            <input type="radio" name="check_galon" @click="hasGalon = false; pilihanGalon = ''" class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                            <span class="ml-3 font-bold text-gray-700 dark:text-gray-200">Belum Ada</span>
                        </label>
                    </div>
                    <div class="mt-4 flex items-center text-blue-600 dark:text-blue-400">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <p class="text-xs font-bold italic">Opsi Isi Ulang hanya tersedia bagi yang memiliki galon.</p>
                    </div>
                </div>

                {{-- Pilih Galon --}}
                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jenis Galon</label>
                    <select name="nama_galon" id="galonSelect" x-model="pilihanGalon"
                        class="form-field w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-600 p-3.5 font-calibri transition-all shadow-sm">
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

                {{-- Jumlah --}}
                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jumlah Pesanan</label>
                    <div class="relative">
                        <input type="number" name="jumlah" min="1" value="1"
                            class="form-field w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-600 p-3.5 font-bold shadow-sm">
                        <div class="absolute right-4 top-3.5 text-gray-400 font-bold"></div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="space-y-2">
                    <label class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Catatan Tambahan</label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Titip di depan pintu kamar..."
                        class="form-field w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-4 focus:ring-blue-500/20 focus:border-blue-600 p-3.5 font-bold shadow-sm"></textarea>
                </div>

                {{-- Hidden Harga --}}
                <input type="hidden" id="hargaInput" name="harga_satuan">

                {{-- Tombol Submit --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center items-center px-8 py-4 bg-blue-600 border border-transparent rounded-2xl font-black text-lg text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 transition-all shadow-xl shadow-blue-500/40 hover:-translate-y-1">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const galons = @json($galons);
    const galonSelect = document.getElementById('galonSelect');
    const hargaInput = document.getElementById('hargaInput');

    galonSelect.addEventListener("change", function () {
        const selected = galons.find(g => g.nama === this.value);
        if (selected) {
            hargaInput.value = selected.harga;
        }
    });
</script>

</x-app-layout>