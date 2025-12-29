<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-[#5B000B] leading-tight">
            {{ __('Detail Transaksi #' . $transaksi->id) }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] border border-[#E7BD8A]/30 shadow-2xl overflow-hidden">
                
                <div class="p-10 pb-0 flex flex-col items-center">
                    <div class="h-16 w-16 bg-[#E7BD8A]/10 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-[#930014]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-light text-[#5B000B] tracking-tight uppercase">Ringkasan <span class="font-bold">Pesanan</span></h3>
                    <p class="text-gray-400 text-xs mt-2">{{ $transaksi->created_at->format('d F Y • H:i') }}</p>
                </div>

                <div class="p-10 space-y-8">
                    <div class="flex justify-center">
                        <span class="px-5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] border
                            @if($transaksi->status == 'pending') border-[#E7BD8A] text-[#E68757] 
                            @elseif($transaksi->status == 'diproses') border-[#E68757] text-[#DB4B3A]
                            @else border-[#930014] text-[#930014] @endif">
                            {{ $transaksi->status }}
                        </span>
                    </div>

                    <div class="space-y-4 border-y border-gray-100 py-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Produk</span>
                            <span class="text-[#5B000B] font-medium text-sm">{{ $transaksi->nama_galon }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Jumlah</span>
                            <span class="text-[#5B000B] font-medium text-sm">{{ $transaksi->jumlah }} Galon</span>
                        </div>
                        <div class="pt-4 flex justify-between items-center">
                            <span class="text-[#E68757] font-bold text-xs uppercase tracking-widest">Total Bayar</span>
                            <span class="text-2xl font-black text-[#930014] tracking-tight">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('galon.history') }}"
                            class="w-full py-4 bg-[#930014] text-white text-xs font-bold rounded-xl text-center hover:bg-[#5B000B] transition-all tracking-widest">
                            KEMBALI KE RIWAYAT
                        </a>
                        @if($transaksi->status == 'selesai')
                        <button onclick="window.print()" class="w-full py-3 bg-white text-gray-500 text-[10px] font-bold rounded-xl border border-gray-100 hover:bg-gray-50 transition-all uppercase tracking-widest">
                            Cetak Bukti
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <p class="mt-8 text-center text-gray-300 text-[9px] font-bold uppercase tracking-[0.4em]">&copy; 2025 TJ-T MART DIGITAL</p>
        </div>
    </div>
</x-app-layout>