<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                Pembelian Token Listrik
            </h2>

            {{-- Tombol Riwayat --}}
            <a href="{{ route('token.history') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Informasi Pengguna --}}
            <div class="bg-gray-800 p-5 rounded-lg mb-6 text-white">
                <h3 class="text-lg font-bold mb-3">Informasi Penghuni</h3>

                <p><b>Nama:</b> {{ Auth::user()->name }}</p>
                <p><b>Gedung:</b> {{ Auth::user()->gedung }}</p>
                <p><b>Kamar:</b> {{ Auth::user()->kamar }}</p>
            </div>

            {{-- FORM PEMBELIAN --}}
            <div class="bg-gray-800 p-6 rounded-lg shadow text-white">

                <form method="POST" action="{{ route('token.store') }}">
                    @csrf

                    {{-- Nominal --}}
                    <label class="font-semibold">Nominal Token</label>
                    <select name="nominal" id="nominal"
                        class="w-full p-2 bg-white rounded mb-3" style="color:black;" required>
                        <option value="" disabled selected>Pilih Nominal</option>
                        @foreach ($tokens as $t)
                        <option value="{{ $t['nominal'] }}" data-harga="{{ $t['harga'] }}">
                            Rp{{ number_format($t['nominal'], 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>

                    <input type="hidden" name="harga" id="harga">

                    {{-- Metode Pembayaran --}}
                    <label class="font-semibold">Metode Pembayaran</label>
                    <select name="metode"
                        class="w-full p-2 bg-white rounded mb-3" style="color:black;" required>
                        <option value="" disabled selected>Pilih Metode</option>
                        <option value="QRIS">QRIS</option>
                        <option value="V-Account">Virtual Account</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="MBanking">Mobile Banking</option>
                    </select>

                    {{-- Tombol --}}
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Beli Sekarang
                    </button>
                </form>

            </div>

        </div>
    </div>

    <script>
        const nominalSelect = document.getElementById('nominal');
        const hargaInput = document.getElementById('harga');

        function updateHarga() {
            const selectedOption = nominalSelect.selectedOptions[0];
            if(selectedOption && selectedOption.dataset.harga){
                hargaInput.value = selectedOption.dataset.harga;
            } else {
                hargaInput.value = '';
            }
        }

        updateHarga();
        nominalSelect.addEventListener('change', updateHarga);
    </script>
</x-app-layout>
