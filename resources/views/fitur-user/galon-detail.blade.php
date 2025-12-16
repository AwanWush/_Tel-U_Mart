<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Detail Transaksi Galon
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 p-6 rounded-lg shadow text-white">
                <h3 class="text-xl font-bold mb-4">Informasi Transaksi</h3>

                <div class="space-y-3">
                    <p><b>Jenis Galon :</b> {{ $transaksi->nama_galon }}</p>
                    <p><b>Jumlah :</b> {{ $transaksi->jumlah }}</p>
                    <p><b>Harga Satuan :</b> Rp{{ number_format($transaksi->harga_satuan, 0, ',', '.') }}</p>
                    <p><b>Total Harga :</b> Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                    <p><b>Catatan :</b> {{ $transaksi->catatan ?? '-' }}</p>
                    <p><b>Status :</b>
                        <span class="px-3 py-1 rounded-full text-white
                            @if($transaksi->status == 'pending') bg-yellow-500
                            @elseif($transaksi->status == 'diproses') bg-blue-500
                            @else bg-green-600 @endif">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </p>
                    <p><b>Waktu Transaksi:</b> {{ $transaksi->created_at }}</p>
                </div>

                <a href="{{ route('galon.history') }}"
                    class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
