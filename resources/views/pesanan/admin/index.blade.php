<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight flex items-center gap-2">
                <span class="p-2 bg-indigo-100 rounded-lg">📋</span>
                Pesanan Masuk
            </h2>
            
            <div class="flex gap-2">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Total: {{ $pesanan->count() }}</span>
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending: {{ $pesanan->where('status', 'Menunggu')->count() }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ activeFilter: 'all' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <button @click="activeFilter = 'all'" 
                    :class="activeFilter === 'all' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-gray-600 hover:bg-gray-50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 border border-transparent">
                    Semua Pesanan
                </button>
                <button @click="activeFilter = 'Menunggu'" 
                    :class="activeFilter === 'Menunggu' ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-100' : 'bg-white text-gray-600 hover:bg-gray-50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 border border-transparent">
                    ⏳ Pending
                </button>
                <button @click="activeFilter = 'Proses'" 
                    :class="activeFilter === 'Proses' ? 'bg-blue-500 text-white shadow-lg shadow-blue-100' : 'bg-white text-gray-600 hover:bg-gray-50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 border border-transparent">
                    🔄 Proses
                </button>
                <button @click="activeFilter = 'Selesai'" 
                    :class="activeFilter === 'Selesai' ? 'bg-green-600 text-white shadow-lg shadow-green-100' : 'bg-white text-gray-600 hover:bg-gray-50'"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 border border-transparent">
                    ✅ Selesai
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">ID Transaksi</th>
                                <th class="px-6 py-4 font-bold">Pelanggan</th>
                                <th class="px-6 py-4 font-bold">Waktu Pesan</th>
                                <th class="px-6 py-4 font-bold">Jenis</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold">Metode</th>
                                <th class="px-6 py-4 font-bold text-right">Total Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pesanan as $p)
                                <tr class="bg-white hover:bg-indigo-50/30 transition-colors duration-150"
                                    x-show="activeFilter === 'all' || activeFilter === '{{ $p->status }}'"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100">
                                    
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <span class="text-indigo-600 font-bold">#{{ $p->id }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                                {{ substr($p->user_id, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-gray-700">User ID: {{ $p->user_id }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-xs">
                                        {{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">
                                            {{ $p->jenis_pesanan }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($p->status === 'Menunggu')
                                                <span class="flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                                    Pending
                                                </span>
                                            @elseif($p->status === 'Proses')
                                                <span class="flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                    Diproses
                                                </span>
                                            @else
                                                <span class="flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-xs font-medium text-gray-600 flex items-center gap-1">
                                            💳 {{ $p->metode_pembayaran }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-black text-gray-900">
                                            Rp{{ number_format($p->total, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-3">
                                                📦
                                            </div>
                                            <p class="text-gray-500 font-medium">Belum ada pesanan yang masuk hari ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>