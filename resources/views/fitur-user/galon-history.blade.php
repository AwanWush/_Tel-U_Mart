<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Riwayat Galon') }}
        </h2>
    </x-slot>

    {{-- Gunakan Background Gradient yang halus agar tidak flat hitam --}}
    <div class="py-12 bg-gray-900 min-h-screen bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-gray-800 via-gray-900 to-black">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ filterStatus: 'semua' }">

            {{-- Header section yang lebih hidup --}}
            <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
                <div>
                    <h3 class="text-4xl font-black text-white tracking-tighter">Riwayat <span class="text-blue-500">Transaksi</span></h3>
                    <p class="text-gray-400 mt-2 font-medium">Pantau status pengiriman galon ke kamar Anda.</p>
                </div>
                
                {{-- Filter Tab yang lebih "Pill" Style --}}
                <div class="flex bg-gray-800/50 backdrop-blur-md p-1.5 rounded-2xl border border-gray-700 shadow-2xl">
                    <button @click="filterStatus = 'semua'" 
                            :class="filterStatus === 'semua' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200'"
                            class="px-6 py-2 rounded-xl text-sm font-bold transition-all duration-300">Semua</button>
                    <button @click="filterStatus = 'pending'" 
                            :class="filterStatus === 'pending' ? 'bg-yellow-500 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200'"
                            class="px-6 py-2 rounded-xl text-sm font-bold transition-all duration-300">Pending</button>
                    <button @click="filterStatus = 'selesai'" 
                            :class="filterStatus === 'selesai' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200'"
                            class="px-6 py-2 rounded-xl text-sm font-bold transition-all duration-300">Selesai</button>
                </div>
            </div>

            @if ($riwayat->isEmpty())
                <div class="bg-gray-800/30 border border-dashed border-gray-700 rounded-3xl py-20 text-center">
                    <p class="text-gray-500 font-bold text-lg">Belum ada aktivitas transaksi.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach ($riwayat as $r)
                        {{-- Card dengan Glassmorphism effect --}}
                        <div class="group relative overflow-hidden bg-gray-800/40 backdrop-blur-sm p-6 rounded-3xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-500"
                             x-show="filterStatus === 'semua' || filterStatus === '{{ $r->status }}'"
                             x-transition:enter="transition transform duration-500"
                             x-transition:enter-start="opacity-0 translate-y-4">
                            
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                                <div class="flex gap-5 items-center">
                                    {{-- Icon Indikator --}}
                                    <div class="h-14 w-14 rounded-2xl flex items-center justify-center 
                                        @if($r->status == 'pending') bg-yellow-500/10 text-yellow-500 
                                        @else bg-blue-500/10 text-blue-500 @endif border border-white/5">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>

                                    <div>
                                        <p class="text-xs font-black text-blue-500 uppercase tracking-widest mb-1">{{ $r->created_at->format('d M Y • H:i') }}</p>
                                        <h4 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors">{{ $r->nama_galon }}</h4>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-2xl font-black text-gray-100">Rp{{ number_format($r->total_harga, 0, ',', '.') }}</span>
                                            <span class="px-3 py-0.5 rounded-lg text-[10px] font-black uppercase border
                                                @if($r->status == 'pending') border-yellow-500/50 text-yellow-500 bg-yellow-500/5 
                                                @else border-green-500/50 text-green-500 bg-green-500/5 @endif">
                                                {{ $r->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full md:w-auto">
                                    <a href="{{ route('galon.detail', $r->id) }}"
                                        class="flex items-center justify-center gap-2 w-full md:w-auto px-8 py-3 bg-white text-black font-black rounded-2xl hover:bg-blue-500 hover:text-white transition-all duration-300 shadow-xl shadow-white/5 hover:shadow-blue-500/20">
                                        LIHAT DETAIL
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>

                            {{-- Dekorasi background --}}
                            <div class="absolute -right-10 -bottom-10 h-32 w-32 bg-blue-600/5 rounded-full blur-3xl group-hover:bg-blue-600/10 transition-colors"></div>
                        </div>
                    @endforeach
                </div>
            @endif

            <footer class="mt-20 py-10 border-t border-gray-800 text-center">
                <p class="text-gray-600 text-xs font-bold uppercase tracking-[0.3em]">&copy; {{ date('Y') }} TJ-T Mart. Digital Logistics.</p>
            </footer>
        </div>
    </div>
</x-app-layout>