<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Riwayat Pembelian Token Listrik
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 p-6 rounded-xl shadow text-white">

                <h3 class="text-xl font-bold mb-4">Riwayat Transaksi</h3>

                @if ($riwayat->isEmpty())
                    <p class="text-gray-300">Belum ada transaksi token.</p>
                @else

                    {{-- LIST STYLE CARD --}}
                    <div class="space-y-4">
                        @foreach ($riwayat as $r)
                            <div class="bg-gray-900 p-4 rounded-lg shadow flex justify-between items-center border border-gray-700">

                                <div>
                                    <p class="text-sm text-gray-400">{{ $r->waktu_transaksi }}</p>
                                    <p class="text-lg font-semibold">Rp{{ number_format($r->nominal, 0, ',', '.') }}</p>

                                    <span class="px-3 py-1 rounded-full text-white text-sm
                                        @if($r->status == 'pending') bg-yellow-500
                                        @elseif($r->status == 'diproses') bg-blue-500
                                        @else bg-green-600 @endif">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </div>

                                <div>
                                    <a href="{{ route('token.detail', $r->id) }}"
                                        class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 text-white text-sm">
                                        Lihat Detail
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>
