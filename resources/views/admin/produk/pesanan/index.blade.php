<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight uppercase tracking-widest">
            📦 Manajemen Pesanan & Logistik
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen text-white font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500 text-emerald-400 rounded-2xl font-bold flex items-center shadow-lg transition-all">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-800 overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] border-b border-white/5 bg-gray-900/50">
                                <th class="px-8 py-6">Invoice & Waktu</th>
                                <th class="px-8 py-6">Pelanggan & Rincian</th>
                                <th class="px-8 py-6 text-right">Total Bayar</th>
                                <th class="px-8 py-6 text-center">Status Bayar</th>
                                <th class="px-8 py-6 text-center">Progres Antar</th>
                                <th class="px-8 py-6 text-right">Kontrol Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-sm">
                            @forelse ($pesanan as $p)
                            <tr class="hover:bg-white/[0.03] transition-all group">
                                {{-- Kolom Invoice --}}
                                <td class="px-8 py-6">
                                    <p class="font-mono text-blue-400 font-black text-base tracking-tighter uppercase">#{{ $p->id_transaksi }}</p>
                                    <p class="text-[10px] font-bold text-gray-500 mt-1">{{ $p->created_at->format('d M Y • H:i') }}</p>
                                </td>

                                {{-- Kolom Pelanggan --}}
                                <td class="px-8 py-6 border-l border-white/5">
                                    <div class="font-black text-slate-100">{{ $p->user->name }}</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest bg-blue-500/10 px-2 py-0.5 rounded">
                                            {{ strtoupper(str_replace('_', ' ', $p->tipe_layanan)) }}
                                        </span>
                                        <button onclick="toggleDetail('modal-{{ $p->id }}')" class="text-[10px] font-bold text-gray-400 hover:text-white underline decoration-dotted">
                                            Lihat Rincian Barang
                                        </button>
                                    </div>

                                    {{-- Modal Detail --}}
                                    <div id="modal-{{ $p->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4">
                                        <div class="bg-gray-800 border border-white/10 rounded-3xl p-8 max-w-md w-full shadow-2xl text-left">
                                            <h3 class="text-xl font-black mb-4">Rincian Barang #{{ $p->id_transaksi }}</h3>
                                            <div class="space-y-3 mb-6">
                                                @foreach($p->details as $item)
                                                    <div class="flex justify-between items-center bg-gray-900/50 p-3 rounded-xl border border-white/5">
                                                        <span class="text-white font-bold">{{ $item->nama_produk }}</span>
                                                        <span class="bg-blue-600 text-white px-3 py-1 rounded-lg font-black italic">x{{ $item->jumlah }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button onclick="toggleDetail('modal-{{ $p->id }}')" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-black uppercase text-xs tracking-widest transition-all">Tutup</button>
                                        </div>
                                    </div>
                                </td>

                                {{-- Total Bayar --}}
                                <td class="px-8 py-6 font-black text-right text-lg text-slate-100">
                                    Rp{{ number_format($p->total_harga, 0, ',', '.') }}
                                </td>

                                {{-- Status Bayar --}}
                                <td class="px-8 py-6 text-center">
                                    <span class="whitespace-nowrap inline-block px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $p->status == 'Lunas' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>

                                {{-- Progres Antar (Teks Diperbarui) --}}
                                <td class="px-8 py-6 text-center">
                                    @php
                                        // Update tampilan teks progres sesuai keinginan Anda
                                        $statusLabel = match($p->status_antar) {
                                            'dikonfirmasi' => 'PROSES KEMAS',
                                            'siap_antar'   => 'SEDANG DIANTAR', // Perubahan teks
                                            'selesai'      => 'SUDAH DIANTAR',  // Perubahan teks
                                            default        => 'MENUNGGU'
                                        };
                                        $statusColor = match($p->status_antar) {
                                            'dikonfirmasi' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'siap_antar'   => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'selesai'      => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            default        => 'bg-gray-500/10 text-gray-400 border-gray-500/20'
                                        };
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase border tracking-widest {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- Kontrol Status (Dropdown Tetap Terkunci) --}}
                                <td class="px-8 py-6 text-right">
                                    <form action="{{ route('admin.orders.update', $p->id) }}" method="POST">
                                        @csrf
                                        <select name="status_antar" onchange="this.form.submit()" 
                                            class="bg-gray-900 border-gray-700 text-[10px] font-black rounded-xl text-white focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer hover:border-blue-400 py-2.5">
                                            
                                            {{-- Option Default hanya terpilih jika status_antar benar-benar null --}}
                                            <option value="" disabled {{ is_null($p->status_antar) ? 'selected' : '' }}>SET STATUS</option>
                                            
                                            {{-- Kondisi selected memastikan pilihan tidak balik ke SET STATUS --}}
                                            <option value="dikonfirmasi" {{ $p->status_antar == 'dikonfirmasi' ? 'selected' : '' }}>TERIMA & PROSES</option>
                                            <option value="siap_antar" {{ $p->status_antar == 'siap_antar' ? 'selected' : '' }}>SIAP DIANTAR</option>
                                            <option value="selesai" {{ $p->status_antar == 'selesai' ? 'selected' : '' }}>SELESAI</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center text-gray-500 font-bold uppercase tracking-widest">
                                    Belum ada pesanan masuk
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDetail(id) {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>