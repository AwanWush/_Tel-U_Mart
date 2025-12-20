<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Detail Transaksi #' . $transaksi->id) }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-gray-800 via-gray-900 to-black">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            {{-- Card Utama --}}
            <div class="relative overflow-hidden bg-gray-800/40 backdrop-blur-xl rounded-[2.5rem] border border-white/10 shadow-2xl">
                
                {{-- Bagian Header Struk --}}
                <div class="p-8 pb-0 flex flex-col items-center">
                    <div class="h-20 w-20 bg-blue-500/20 rounded-2xl flex items-center justify-center border border-blue-500/30 mb-4 shadow-inner">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-white tracking-tighter">Ringkasan <span class="text-blue-500">Pesanan</span></h3>
                    <p class="text-gray-400 font-medium mt-1">{{ $transaksi->created_at->format('d F Y • H:i') }}</p>
                </div>

                {{-- Konten Detail --}}
                <div class="p-8 space-y-6">
                    {{-- Status Badge Large --}}
                    <div class="flex justify-center mb-4">
                        <span class="px-6 py-2 rounded-2xl text-sm font-black uppercase tracking-widest border
                            @if($transaksi->status == 'pending') border-yellow-500/50 text-yellow-500 bg-yellow-500/5 
                            @elseif($transaksi->status == 'diproses') border-blue-500/50 text-blue-500 bg-blue-500/5
                            @else border-green-500/50 text-green-500 bg-green-500/5 @endif">
                            {{ $transaksi->status }}
                        </span>
                    </div>

                    {{-- Info Grid --}}
                    <div class="space-y-4 bg-black/20 rounded-3xl p-6 border border-white/5">
                        <div class="flex justify-between items-center border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Produk</span>
                            <span class="text-white font-bold text-right">{{ $transaksi->nama_galon }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Harga Satuan</span>
                            <span class="text-white font-bold text-right">Rp{{ number_format($transaksi->harga_satuan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Jumlah</span>
                            <span class="text-white font-bold text-right">{{ $transaksi->jumlah }} Galon</span>
                        </div>
                        <div class="flex flex-col gap-2 border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Catatan Pembeli</span>
                            <span class="text-gray-300 italic text-sm">{{ $transaksi->catatan ?? 'Tidak ada catatan' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-blue-400 font-black uppercase text-xs tracking-[0.2em]">Total Bayar</span>
                            <span class="text-3xl font-black text-white tracking-tighter">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Tombol Navigasi --}}
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('galon.history') }}"
                            class="w-full flex items-center justify-center gap-2 py-4 bg-white text-black font-black rounded-2xl hover:bg-blue-500 hover:text-white transition-all duration-300 shadow-xl shadow-white/5">
                            <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            KEMBALI KE RIWAYAT
                        </a>
                        {{-- Contoh tombol interaktif tambahan (Opsional) --}}
                        @if($transaksi->status == 'selesai')
                        <button onclick="window.print()" class="w-full py-4 bg-gray-800 text-gray-300 font-bold rounded-2xl border border-white/10 hover:bg-gray-700 transition-all">
                            UNDUH BUKTI BAYAR (PDF)
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Dekorasi Absolut --}}
                <div class="absolute -left-10 -top-10 h-32 w-32 bg-blue-600/10 rounded-full blur-3xl"></div>
                <div class="absolute -right-20 -bottom-20 h-40 w-40 bg-purple-600/5 rounded-full blur-3xl"></div>
            </div>

            <p class="mt-8 text-center text-gray-600 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART DIGITAL RECEIPT</p>
        </div>
    </div>
</x-app-layout>