<x-app-layout>
    <div class="py-16 bg-gray-50 min-h-screen"> {{-- py-16 untuk posisi lebih ke bawah --}}
        <div class="max-w-7xl mx-auto px-4 space-y-10">

            {{-- Header & Filter Section --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div>
                    <h2 class="text-3xl font-black text-red-700 uppercase tracking-tighter">
                        Laporan Penjualan
                    </h2>
                    <p class="text-gray-500 text-sm">Monitoring performa penjualan Mart Anda</p>
                </div>

                <form method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="flex gap-2">
                        <select name="bulan" class="rounded-xl border-gray-200 text-sm focus:ring-red-500 focus:border-red-500 shadow-sm">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0,0,0,$i,1)) }}
                                </option>
                            @endfor
                        </select>

                        <select name="tahun" class="rounded-xl border-gray-200 text-sm focus:ring-red-500 focus:border-red-500 shadow-sm">
                            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button class="bg-red-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-red-700 transition-all hover:shadow-lg active:scale-95">
                        Tampilkan
                    </button>
                </form>
            </div>

            {{-- Ringkasan Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $stats = [
                        ['label' => 'Total Transaksi', 'value' => $totalTransaksi, 'unit' => 'Nota'],
                        ['label' => 'Total Omset', 'value' => 'Rp ' . number_format($totalOmset), 'unit' => 'Rupiah'],
                        ['label' => 'Metode Cash', 'value' => 'Rp ' . number_format($totalCash), 'unit' => 'Tunai'],
                        ['label' => 'Metode QRIS', 'value' => 'Rp ' . number_format($totalQRIS), 'unit' => 'Digital'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                <div class="bg-white p-6 rounded-2xl border-b-4 border-red-600 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $stat['value'] }}</h3>
                    <p class="text-[10px] text-red-500 mt-2 font-medium italic">*{{ $stat['unit'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Tabel Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="font-bold text-gray-700">Rincian Transaksi Terakhir</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-red-600 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 text-left font-bold">Tanggal</th>
                                <th class="p-4 text-left font-bold">Metode</th>
                                <th class="p-4 text-right font-bold">Total Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($penjualan as $row)
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="p-4 text-gray-600">
                                        <span class="block font-medium">{{ $row->tanggal_penjualan->format('d M Y') }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $row->tanggal_penjualan->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $row->metode_pembayaran == 'QRIS' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $row->metode_pembayaran }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <span class="text-lg font-bold text-gray-800 italic">Rp {{ number_format($row->total) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="text-gray-300 mb-2">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </span>
                                            <p class="text-gray-500 font-medium">Belum ada data penjualan pada periode ini.</p>
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