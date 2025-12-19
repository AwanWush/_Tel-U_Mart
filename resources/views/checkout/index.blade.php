<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Checkout</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @foreach($items as $item)
                <div class="flex justify-between mb-2">
                    <span>{{ $item->produk->nama_produk }} (x{{ $item->quantity }})</span>
                    <span>Rp {{ number_format($item->quantity * $item->price) }}</span>
                </div>
            @endforeach

            <hr class="my-4">

            <div class="flex justify-between font-bold text-lg">
                <span>Total</span>
                <span>Rp {{ number_format($total) }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
