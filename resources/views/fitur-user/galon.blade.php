<x-app-layout>

<style>
    /* Hanya teks di dalam input, select, textarea yang hitam */
    .form-field {
        color: #000 !important;
    }
</style>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Beli Galon
    </h2>
</x-slot>

<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        {{-- Tombol Riwayat --}}
        <div class="flex justify-end mb-5">
            <a href="{{ route('galon.history') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Riwayat Pembelian
            </a>
        </div>

        {{-- Informasi Pengguna --}}
        <div class="bg-gray-800 p-5 rounded-lg mb-6 text-white shadow-md">
            <h3 class="text-lg font-bold mb-3">Informasi Penghuni</h3>

            <p><b>Nama:</b> {{ Auth::user()->name }}</p>
            <p><b>Gedung:</b> {{ Auth::user()->gedung }}</p>
            <p><b>Kamar:</b> {{ Auth::user()->kamar }}</p>
        </div>

        {{-- Form Pemesanan --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <h3 class="text-2xl font-bold text-white mb-6">
                Pesan Galon
            </h3>

            <form action="{{ route('galon.store') }}" method="POST">
                @csrf

                {{-- Pilih Galon --}}
                <div class="mb-5">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Pilih Jenis Galon
                    </label>

                    <select name="nama_galon"
                        class="form-field w-full rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-2">
                        @foreach($galons as $g)
                            <option value="{{ $g['nama'] }}">
                                {{ $g['nama'] }} - Rp{{ number_format($g['harga'],0,',','.') }}
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden" id="hargaInput" name="harga_satuan" value="{{ $galons[0]['harga'] }}">
                </div>

                {{-- Jumlah --}}
                <div class="mb-5">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Jumlah Galon</label>
                    <input type="number" name="jumlah" min="1" value="1"
                        class="form-field w-full rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-2">
                </div>

                {{-- Catatan --}}
                <div class="mb-5">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Catatan</label>
                    <textarea name="catatan" rows="3"
                        class="form-field w-full rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-2"></textarea>
                </div>

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Pesan Sekarang
                </button>

            </form>

        </div>

    </div>
</div>

</x-app-layout>

<script>
    const galons = @json($galons);

    document.querySelector("select[name='nama_galon']").addEventListener("change", function () {
        const selected = galons.find(g => g.nama === this.value);
        document.getElementById("hargaInput").value = selected.harga;
    });
</script>
