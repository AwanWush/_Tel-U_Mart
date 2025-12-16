<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg">

        <h2 class="text-2xl font-bold mb-3 text-center text-green-700">Pembelian Berhasil</h2>

        <p><b>Token Anda:</b> {{ $transaksi->token_kode }}</p>
        <p><b>Nominal:</b> Rp{{ number_format($transaksi->nominal, 0, ',', '.') }}</p>
        <p><b>Waktu:</b> {{ $transaksi->waktu_transaksi }}</p>
        <p><b>Status:</b> {{ $transaksi->status }}</p>

        <a href="{{ route('token.index') }}" 
           class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            Kembali
        </a>

    </div>
</x-app-layout>
