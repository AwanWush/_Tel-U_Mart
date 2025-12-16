<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Pesanan Galon Berhasil Dibuat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <h3 class="text-2xl font-bold text-white mb-6">
                    Detail Pemesanan Galon
                </h3>

                <div class="space-y-4">

                    {{-- Nama Galon --}}
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Nama Galon</p>
                        <p class="text-lg font-semibold text-white">
                            {{ $transaksi->nama_galon }}
                        </p>
                    </div>

                    {{-- Jumlah --}}
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Jumlah</p>
                        <p class="text-lg font-semibold text-white">
                            {{ $transaksi->jumlah }} Galon
                        </p>
                    </div>

                    {{-- Harga Satuan --}}
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Harga Satuan</p>
                        <p class="text-lg font-semibold text-white">
                            Rp{{ number_format($transaksi->harga_satuan, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Total Harga --}}
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Total Harga</p>
                        <p class="text-xl font-bold" style="color: white !important;">
                            Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </p>
                    </div>




                    {{-- Catatan --}}
                    @if ($transaksi->catatan)
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Catatan</p>
                        <p class="text-lg text-white">
                            {{ $transaksi->catatan }}
                        </p>
                    </div>
                    @endif

                    {{-- Waktu --}}
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Waktu Transaksi</p>
                        <p class="text-lg font-semibold text-white">
                            {{ $transaksi->waktu_transaksi }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="p-4 rounded-lg bg-gray-700">
                        <p class="text-gray-300 text-sm">Status</p>
                        <span class="px-3 py-1 text-sm rounded-full text-white
                            @if($transaksi->status == 'pending') bg-yellow-500
                            @elseif($transaksi->status == 'diproses') bg-blue-500
                            @elseif($transaksi->status == 'selesai') bg-green-600
                            @else bg-gray-500 @endif">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('galon.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Pesan Lagi
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
