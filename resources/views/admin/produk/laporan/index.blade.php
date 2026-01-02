<x-app-layout>
    {{-- padding-top tetap 120px agar turun dari navbar --}}
    <div class="bg-gray-50 min-h-screen pb-12" style="padding-top: 120px;"> 
        <div class="max-w-7xl mx-auto px-4 space-y-8">

            {{-- HEADER --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-3xl font-black text-red-700 uppercase tracking-tighter">
                    Laporan Penjualan
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                </p>
            </div>

            {{-- FILTER --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Bulan</label>
                        <select name="bulan" class="rounded-xl border-gray-200 text-sm focus:ring-red-500 focus:border-red-500 shadow-sm">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0,0,0,$i,1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Tahun</label>
                        <select name="tahun" class="rounded-xl border-gray-200 text-sm focus:ring-red-500 focus:border-red-500 shadow-sm">
                            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- TOMBOL: Menggunakan inline style untuk mengunci warna teks --}}
                    <button type="submit"
                        style="color: white !important; background-color: #dc2626;" 
                        onmouseover="this.style.backgroundColor='#991b1b'"
                        onmouseout="this.style.backgroundColor='#dc2626'"
                        class="px-6 py-2 rounded-xl font-bold transition-all shadow-md active:scale-95">
                        Tampilkan
                    </button>
                </form>
            </div>

            {{-- RINGKASAN --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border-b-4 border-red-600 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Transaksi</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $totalTransaksi }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border-b-4 border-red-600 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Omset</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">Rp {{ number_format($totalOmset) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border-b-4 border-red-600 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Cash</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">Rp {{ number_format($totalCash) }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl border-b-4 border-red-600 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">QRIS</p>
                    <h3 class="text-2xl font-black text-gray-800 mt-1">Rp {{ number_format($totalQRIS) }}</h3>
                </div>
            </div>

            {{-- TABEL --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b bg-gray-50">
                    <h3 class="font-bold text-gray-700">Rincian Transaksi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-red-600 text-white text-sm uppercase">
                                <th class="p-4 text-left font-bold" style="color: white !important;">Tanggal</th>
                                <th class="p-4 text-left font-bold" style="color: white !important;">Metode</th>
                                <th class="p-4 text-right font-bold" style="color: white !important;">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($penjualan as $row)
                                <tr class="hover:bg-red-50">
                                    <td class="p-4 text-gray-700">
                                        {{ \Carbon\Carbon::parse($row->tanggal_penjualan)->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-gray-700">
                                        {{ $row->metode_pembayaran }}
                                    </td>
                                    <td class="p-4 text-right font-bold text-gray-800">
                                        Rp {{ number_format($row->total) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-10 text-center text-gray-500 font-bold italic">
                                        Belum ada data penjualan pada periode ini.
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