<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white tracking-widest uppercase">Riwayat Belanja 🛍️</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 font-sans">
        @if($riwayat->isEmpty())
            <div class="bg-[#5B000B]/50 p-20 text-center rounded-[3rem] border border-white/5 shadow-inner">
                <div class="text-7xl mb-6 opacity-20">🛒</div>
                <p class="text-[#E7BD8A] font-black uppercase tracking-[0.2em] text-xs">Belum ada riwayat belanja</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($riwayat as $r)
                    <div class="bg-[#5B000B]/40 border border-white/5 rounded-[2.5rem] overflow-hidden shadow-xl">
                        {{-- Header Invoice --}}
                        <div class="bg-[#5B000B] p-6 border-b border-white/5 flex justify-between items-center">
                            <div>
                                <p class="text-[10px] font-black text-[#E7BD8A] uppercase tracking-widest">Invoice</p>
                                <h3 class="text-white font-black text-lg">#{{ $r->id_transaksi }}</h3>
                            </div>
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $r->status == 'Lunas' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400' }}">
                                {{ $r->status }}
                            </span>
                        </div>

                        {{-- Rincian Produk --}}
                        <div class="p-8">
                            <div class="space-y-4">
                                @foreach($r->details as $item)
                                    <div class="flex justify-between items-center bg-black/20 p-4 rounded-2xl border border-white/5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-[#930014] rounded-lg flex items-center justify-center text-white font-black italic text-xs">
                                                x{{ $item->jumlah }}
                                            </div>
                                            <span class="text-white font-bold uppercase text-sm tracking-tight">{{ $item->nama_produk }}</span>
                                        </div>
                                        <div>
                                            <span class="text-white font-bold uppercase text-sm tracking-tight">
                                                {{ $item->nama_produk }}
                                            </span>

                                            @if($item->keterangan)
                                                <p class="text-[10px] text-[#E7BD8A] font-mono mt-1">
                                                    {{ $item->keterangan }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer Total --}}
                            <div class="mt-8 pt-6 border-t border-white/5 flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Layanan</p>
                                    <p class="text-white font-bold text-sm">{{ strtoupper(str_replace('_', ' ', $r->tipe_layanan)) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-[#E7BD8A] uppercase tracking-widest">Total Bayar</p>
                                    <p class="text-2xl font-black text-white">Rp{{ number_format($r->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $riwayat->links() }}</div>
        @endif
    </div>
</x-app-layout>