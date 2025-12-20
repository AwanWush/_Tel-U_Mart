<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
            ⚡ Detail <span class="text-blue-500">Token</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-gray-800 via-gray-900 to-black">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8" x-data="{ 
            copyText: '{{ $transaksi->kode_token }}',
            copied: false,
            copyToClipboard() {
                navigator.clipboard.writeText(this.copyText);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        }">

            {{-- Card Utama --}}
            <div class="relative overflow-hidden bg-gray-800/40 backdrop-blur-xl rounded-[2.5rem] border border-white/10 shadow-2xl">
                
                {{-- Header Detail --}}
                <div class="p-8 pb-4 flex flex-col items-center">
                    <div class="h-20 w-20 bg-yellow-500/20 rounded-2xl flex items-center justify-center border border-yellow-500/30 mb-4 shadow-inner animate-pulse">
                        <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Token <span class="text-blue-500">Berhasil</span></h3>
                    <p class="text-gray-400 font-bold mt-1 uppercase text-[10px] tracking-[0.3em]">{{ $transaksi->created_at->format('d F Y • H:i') }}</p>
                </div>

                <div class="p-8 pt-4 space-y-6">
                    {{-- KODE TOKEN BOX (INTERAKTIF) --}}
                    <div class="bg-gray-900/80 rounded-3xl p-6 border border-blue-500/30 text-center relative group">
                        <p class="text-blue-400 font-black text-[10px] uppercase tracking-[0.3em] mb-4">Kode Token Anda</p>
                        
                        <div class="flex flex-col gap-4">
                            <span class="text-3xl md:text-4xl font-black tracking-[0.2em] text-white font-mono">
                                {{ $transaksi->kode_token }}
                            </span>
                            
                            <button @click="copyToClipboard" 
                                    :class="copied ? 'bg-green-600 text-white' : 'bg-blue-600 hover:bg-blue-500 text-white'"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded-xl text-xs font-black uppercase transition-all shadow-lg">
                                <template x-if="!copied">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                        SALIN KODE
                                    </div>
                                </template>
                                <template x-if="copied">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        TERSALIN!
                                    </div>
                                </template>
                            </button>
                        </div>
                    </div>

                    {{-- RINGKASAN DATA --}}
                    <div class="bg-black/20 rounded-3xl p-6 border border-white/5 space-y-4">
                        <div class="flex justify-between items-center border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Nominal</span>
                            <span class="text-white font-bold">Rp{{ number_format($transaksi->nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Metode Pembayaran</span>
                            <span class="text-blue-400 font-bold uppercase">{{ $transaksi->metode }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/5 pb-3">
                            <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Gedung / Kamar</span>
                            <span class="text-white font-bold">{{ $transaksi->gedung }} - {{ $transaksi->kamar }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-gray-400 font-black uppercase text-xs tracking-[0.2em]">Total Bayar</span>
                            <span class="text-2xl font-black text-white">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- NAVIGATION --}}
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('token.history') }}"
                            class="w-full flex items-center justify-center gap-2 py-4 bg-white text-black font-black rounded-2xl hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-xl shadow-white/5">
                            <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            KEMBALI KE RIWAYAT
                        </a>
                        <button onclick="window.print()" class="text-gray-500 font-bold text-[10px] uppercase tracking-widest hover:text-gray-300 transition-colors">
                            Cetak Bukti Transaksi
                        </button>
                    </div>
                </div>

                {{-- Dekorasi Absolut --}}
                <div class="absolute -left-10 -top-10 h-32 w-32 bg-yellow-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -right-20 -bottom-20 h-40 w-40 bg-blue-600/5 rounded-full blur-3xl"></div>
            </div>

            <p class="mt-8 text-center text-gray-600 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART DIGITAL LOGISTICS</p>
        </div>
    </div>
</x-app-layout>