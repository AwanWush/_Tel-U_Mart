<x-app-layout>
    <div class="pt-[100px]"> {{-- Padding luar yang lebih kecil --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 mb-4 text-sm font-bold text-gray-500">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#dc2626] transition-colors" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                    </svg>
                    <span class="tracking-wide">Dashboard</span>
                </a>
            </nav>
            <div class="flex items-center gap-0 mb-6">
                <span class="text-2xl"></span>
                <h2 class="text-xl font-bold text-red-700 uppercase tracking-widest">
                    Pesanan Masuk
                </h2>
            </div>
        </div>
    </div>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-10">

            @if (session('success'))
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-red-600 text-white uppercase text-xs tracking-widest">
                            <th class="px-6 py-4 text-left">Invoice & Waktu</th>
                            <th class="px-6 py-4 text-left">Pelanggan</th>
                            <th class="px-6 py-4 text-right">Total Bayar</th>
                            <th class="px-6 py-4 text-center">Status Bayar</th>
                            <th class="px-6 py-4 text-center">Progres Antar</th>
                            <th class="px-6 py-4 text-center">Kontrol</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($pesanan as $p)
                            <tr class="hover:bg-red-50 transition">

                                <td class="px-6 py-4">
                                    <div class="font-mono font-bold text-red-600">#{{ $p->id_transaksi }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $p->created_at->format('d M Y • H:i') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">{{ $p->user->name }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span
                                            class="text-[10px] px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-bold uppercase">
                                            {{ strtoupper(str_replace('_', ' ', $p->tipe_layanan)) }}
                                        </span>
                                        <button onclick="toggleDetail('modal-{{ $p->id }}')"
                                            class="text-xs text-red-600 hover:underline">
                                            Lihat rincian
                                        </button>
                                    </div>

                                    <div id="modal-{{ $p->id }}"
                                        class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
                                        <div class="bg-white rounded-2xl p-6 max-w-md w-full">
                                            <h3 class="font-bold text-red-700 mb-4">
                                                Rincian Pesanan #{{ $p->id_transaksi }}
                                            </h3>
                                            <div class="space-y-2 mb-4">
                                                @foreach ($p->details as $item)
                                                    <div class="flex justify-between bg-gray-100 px-3 py-2 rounded">
                                                        <span class="font-medium">{{ $item->nama_produk }}</span>
                                                        <span
                                                            class="font-bold text-red-600">x{{ $item->jumlah }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button onclick="toggleDetail('modal-{{ $p->id }}')"
                                                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-xl font-bold text-xs uppercase">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-gray-800">
                                    Rp{{ number_format($p->total_harga, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $p->status == 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ strtoupper($p->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $label = match ($p->status_antar) {
                                            'dikonfirmasi' => 'PROSES KEMAS',
                                            'siap_antar' => 'DIANTAR',
                                            'selesai' => 'SELESAI',
                                            default => 'MENUNGGU',
                                        };
                                        $color = match ($p->status_antar) {
                                            'dikonfirmasi' => 'bg-red-100 text-red-700',
                                            'siap_antar' => 'bg-yellow-100 text-yellow-700',
                                            'selesai' => 'bg-green-100 text-green-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.orders.update', $p->id) }}" method="POST">
                                        @csrf
                                        <select name="status_antar" onchange="this.form.submit()"
                                            class="w-[150px] text-center text-xs font-bold rounded-full
                                    border border-red-300 bg-white text-red-700
                                    px-4 py-1.5
                                    focus:outline-none focus:ring-2 focus:ring-red-400
                                    hover:bg-red-50 transition cursor-pointer">

                                            <option disabled {{ is_null($p->status_antar) ? 'selected' : '' }}>
                                                SET STATUS
                                            </option>
                                            <option value="dikonfirmasi"
                                                {{ $p->status_antar == 'dikonfirmasi' ? 'selected' : '' }}>
                                                PROSES
                                            </option>
                                            <option value="siap_antar"
                                                {{ $p->status_antar == 'siap_antar' ? 'selected' : '' }}>
                                                DIANTAR
                                            </option>
                                            <option value="selesai" {{ $p->status_antar == 'selesai' ? 'selected' : '' }}>
                                                SELESAI
                                            </option>
                                        </select>
                                    </form>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="py-20 text-center text-gray-400 font-bold uppercase tracking-widest">
                                    Belum ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function toggleDetail(id) {
            document.getElementById(id).classList.toggle('hidden')
        }
    </script>
</x-app-layout>
