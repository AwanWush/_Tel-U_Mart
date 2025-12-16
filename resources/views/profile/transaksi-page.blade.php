<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Transaksi Saya</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <aside class="p-6 bg-white shadow sm:rounded-lg">
            <h4 class="font-medium mb-2">Transaksi</h4>
            <ul class="space-y-2">
                <li><a href="{{ route('profil.transaksi.page', ['status'=>'Terbuat']) }}" class="text-indigo-600">Terbuat</a></li>
                <li><a href="{{ route('profil.transaksi.page', ['status'=>'Menunggu Pembayaran']) }}">Menunggu Pembayaran</a></li>
                <li><a href="{{ route('profil.transaksi.page', ['status'=>'Sedang Diproses']) }}">Sedang Diproses</a></li>
                <li><a href="{{ route('profil.transaksi.page', ['status'=>'Dikirim']) }}">Dikirim</a></li>
                <li><a href="{{ route('profil.transaksi.page', ['status'=>'Sudah Tiba']) }}">Selesai</a></li>
                <li><a href="{{ route('profil.transaksi.page', ['status'=>'Batal']) }}">Batal</a></li>
            </ul>
        </aside>

        <main class="md:col-span-3 p-6 bg-white shadow sm:rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Daftar Transaksi</h3>

            <x-transaksi-table :transaksi="$transaksi" :filter="($statusFilter ?? null)"/>

            <div class="mt-6">
                <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:underline">Kembali ke Profil</a>
            </div>
        </main>
    </div>

    @if($item->status == 'Menunggu Pembayaran')
        <button 
            class="px-3 py-2 bg-indigo-600 text-white rounded mt-2 pay-button"
            data-id="{{ $item->id }}"
            data-amount="{{ $item->total_harga }}">
            Bayar Sekarang
        </button>
    @endif


<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.pay-button').forEach(btn => {
        btn.addEventListener('click', function () {

            const id = this.dataset.id;
            const amount = this.dataset.amount;

            fetch("/payment/create", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    transaction_id: id,
                    amount: amount
                })
            })
            .then(res => res.json())
            .then(data => {
                snap.pay(data.snap_token);
            });
        });
    });
});
</script>

</x-app-layout>
