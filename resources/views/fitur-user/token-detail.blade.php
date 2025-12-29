<x-app-layout>
    <style>
        .bg-red-main { background-color: #dc2626; } /* Tailwind red-600 */
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        .bg-red-soft { background-color: #fee2e2; } /* Tailwind red-100 */
        .text-primary-accent { color: #DB4B3A; } /* Menggunakan warna aksen dari token.blade.php */
    </style>

    {{-- Header disesuaikan dengan gaya halaman token.blade.php (Light Mode Header) --}}
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tight uppercase">
                ⚡ Detail <span class="text-red-main">Token</span>
            </h2>
        </div>
    </x-slot>

    {{-- Latar Belakang Utama diubah menjadi Light Mode (bg-gray-50) --}}
    <div class="py-12 min-h-screen bg-gray-50">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8" x-data="{ 
            copyText: '{{ $transaksi->kode_token }}',
            copied: false,
            copyToClipboard() {
                navigator.clipboard.writeText(this.copyText);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        }">

            {{-- Card Utama diubah ke Light Mode (bg-white) --}}
            <div class="relative overflow-hidden bg-white rounded-[2.5rem] border-2 border-red-main/10 shadow-2xl shadow-red-main/10">
                
                {{-- Header Detail --}}
                <div class="p-8 pb-4 flex flex-col items-center">
                    {{-- Icon disesuaikan menjadi merah --}}
                    <div class="h-20 w-20 bg-red-main/10 rounded-2xl flex items-center justify-center border border-red-main/30 mb-4 shadow-inner">
                        <svg class="w-10 h-10 text-red-main" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 tracking-tighter uppercase">Token <span class="text-red-main">Berhasil</span></h3>
                    <p class="text-gray-500 font-bold mt-1 uppercase text-[10px] tracking-[0.3em]">{{ $transaksi->created_at->format('d F Y • H:i') }}</p>
                </div>

                <div class="p-8 pt-4 space-y-6">
                    {{-- KODE TOKEN BOX (INTERAKTIF) diubah ke Light Mode --}}
                    <div class="bg-red-soft/50 rounded-3xl p-6 border-2 border-red-main/30 text-center relative group">
                        <p class="text-red-main font-black text-[10px] uppercase tracking-[0.3em] mb-4">Kode Token Anda</p>
                        
                        <div class="flex flex-col gap-4">
                            {{-- Warna teks kode token --}}
                            <span class="text-3xl md:text-4xl font-black tracking-[0.2em] text-gray-900 font-mono">
                                {{ $transaksi->kode_token }}
                            </span>
                            
                            {{-- Tombol Salin diubah ke warna merah utama --}}
                            <button @click="copyToClipboard" 
                                    :class="copied ? 'bg-green-600 hover:bg-green-500 text-white shadow-green-400/50' : 'bg-red-main hover:bg-red-hover text-white shadow-red-main/50'"
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

                    {{-- RINGKASAN DATA diubah ke Light Mode (bg-gray-50) --}}
                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-200 space-y-4 shadow-inner">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                            <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Nominal</span>
                            <span class="text-gray-900 font-bold">Rp{{ number_format($transaksi->nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                            <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Metode Pembayaran</span>
                            <span class="text-red-main font-bold uppercase">{{ $transaksi->metode }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                            <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Gedung / Kamar</span>
                            <span class="text-gray-900 font-bold">{{ $transaksi->gedung }} - {{ $transaksi->kamar }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-gray-500 font-black uppercase text-xs tracking-[0.2em]">Total Bayar</span>
                            <span class="text-2xl font-black text-red-main">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- NAVIGATION --}}
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('token.history') }}"
                            {{-- Tombol utama diubah ke warna merah --}}
                            class="w-full flex items-center justify-center gap-2 py-4 bg-red-main text-white font-black rounded-2xl hover:bg-red-hover transition-all duration-300 shadow-xl shadow-red-main/30">
                            <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            KEMBALI KE RIWAYAT
                        </a>
                        {{-- Tombol cetak --}}
                        <button onclick="window.print()" class="text-gray-500 font-bold text-[10px] uppercase tracking-widest hover:text-red-main transition-colors">
                            Cetak Bukti Transaksi
                        </button>
                    </div>
                </div>

                {{-- Dekorasi Absolut diubah ke Light Mode --}}
                <div class="absolute -left-10 -top-10 h-32 w-32 bg-red-main/10 rounded-full blur-3xl"></div>
                <div class="absolute -right-20 -bottom-20 h-40 w-40 bg-red-main/5 rounded-full blur-3xl"></div>
            </div>

            {{-- Footer Text --}}
            <p class="mt-8 text-center text-gray-500 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART DIGITAL LOGISTICS</p>
        </div>
    </div>
</x-app-layout>