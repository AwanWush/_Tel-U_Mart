<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
            ⚡ Riwayat <span class="text-blue-500">Token Listrik</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-gray-800 via-gray-900 to-black">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ filterStatus: 'semua' }">

            {{-- Header & Filter Interaktif --}}
            <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
                <div>
                    <h3 class="text-4xl font-black text-white tracking-tighter uppercase">Daftar <span class="text-blue-500">Transaksi</span></h3>
                    <p class="text-gray-400 mt-2 font-medium italic">Simpan dan pantau kode token listrik Anda di sini.</p>
                </div>
                
                {{-- Filter Tab Modern --}}
                <div class="flex bg-gray-800/50 backdrop-blur-md p-1.5 rounded-2xl border border-gray-700 shadow-2xl">
                    <button @click="filterStatus = 'semua'" 
                            :class="filterStatus === 'semua' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200'"
                            class="px-6 py-2 rounded-xl text-xs font-black uppercase transition-all duration-300">Semua</button>
                    <button @click="filterStatus = 'Berhasil'" 
                            :class="filterStatus === 'Berhasil' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200'"
                            class="px-6 py-2 rounded-xl text-xs font-black uppercase transition-all duration-300">Berhasil</button>
                </div>
            </div>

            <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/10 shadow-2xl">
                @if ($riwayat->isEmpty())
                    <div class="text-center py-20">
                        <div class="inline-flex p-6 bg-gray-900/50 rounded-full mb-4 border border-white/5">
                            <svg class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-bold text-lg uppercase tracking-widest">Belum ada transaksi token.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($riwayat as $r)
                            {{-- Card Transaksi dengan Glassmorphism & Hover Effect --}}
                            <div class="group relative overflow-hidden bg-gray-900/60 p-6 rounded-3xl border border-white/5 hover:border-blue-500/50 transition-all duration-500 shadow-xl"
                                 x-show="filterStatus === 'semua' || filterStatus === '{{ $r->status }}'"
                                 x-transition:enter="transition transform duration-500"
                                 x-transition:enter-start="opacity-0 translate-y-4">

                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                                    <div class="flex gap-5 items-center">
                                        {{-- Icon Power --}}
                                        <div class="h-14 w-14 rounded-2xl flex items-center justify-center bg-blue-500/10 text-blue-500 border border-blue-500/20 shadow-inner">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>

                                        <div>
                                            {{-- Perbaikan: Menggunakan created_at agar tidak error --}}
                                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-1">
                                                {{ $r->created_at ? $r->created_at->format('d M Y • H:i') : '-' }}
                                            </p>
                                            <h4 class="text-2xl font-black text-white group-hover:text-blue-400 transition-colors tracking-tighter">
                                                Rp{{ number_format($r->nominal, 0, ',', '.') }}
                                            </h4>
                                            <div class="flex items-center gap-3 mt-2">
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Status:</span>
                                                <span class="px-3 py-0.5 rounded-lg text-[10px] font-black uppercase border
                                                    @if($r->status == 'Berhasil') border-green-500/50 text-green-500 bg-green-500/5 
                                                    @else border-yellow-500/50 text-yellow-500 bg-yellow-500/5 @endif">
                                                    {{ $r->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full md:w-auto">
                                        <a href="{{ route('token.detail', $r->id) }}"
                                            class="flex items-center justify-center gap-2 w-full md:w-auto px-8 py-3 bg-white text-black font-black rounded-2xl hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-xl shadow-white/5">
                                            LIHAT KODE
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                {{-- Dekorasi Background --}}
                                <div class="absolute -right-10 -bottom-10 h-32 w-32 bg-blue-600/5 rounded-full blur-3xl group-hover:bg-blue-600/10 transition-colors"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <footer class="mt-16 py-10 border-t border-white/5 text-center">
                <p class="text-gray-600 text-[10px] font-black uppercase tracking-[0.4em]">&copy; {{ date('Y') }} TJ-T Mart Smart Energy System</p>
            </footer>

        </div>
    </div>
</x-app-layout>