<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-[#5B000B] leading-tight">
            {{ __('Riwayat Galon') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" x-data="{ filterStatus: 'semua' }">

            <div class="mb-12 flex flex-col md:flex-row justify-between items-center gap-6">
                <h3 class="text-3xl font-light text-[#5B000B] tracking-tight">Riwayat <span class="font-bold">Transaksi</span></h3>
                
                <div class="flex bg-gray-50 p-1 rounded-xl border border-gray-100">
                    <button @click="filterStatus = 'semua'" 
                            :class="filterStatus === 'semua' ? 'bg-white shadow-sm text-[#930014]' : 'text-gray-400'"
                            class="px-5 py-2 rounded-lg text-xs font-bold transition-all">Semua</button>
                    <button @click="filterStatus = 'pending'" 
                            :class="filterStatus === 'pending' ? 'bg-white shadow-sm text-[#E68757]' : 'text-gray-400'"
                            class="px-5 py-2 rounded-lg text-xs font-bold transition-all">Pending</button>
                    <button @click="filterStatus = 'selesai'" 
                            :class="filterStatus === 'selesai' ? 'bg-white shadow-sm text-[#930014]' : 'text-gray-400'"
                            class="px-5 py-2 rounded-lg text-xs font-bold transition-all">Selesai</button>
                </div>
            </div>

            @if ($riwayat->isEmpty())
                <div class="bg-gray-50 border border-dashed border-[#E7BD8A] rounded-3xl py-20 text-center">
                    <p class="text-gray-400 text-sm font-medium">Belum ada aktivitas transaksi.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($riwayat as $r)
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 hover:border-[#E7BD8A] transition-all shadow-sm flex flex-col md:flex-row justify-between items-center gap-4"
                             x-show="filterStatus === 'semua' || filterStatus === '{{ $r->status }}'">
                            
                            <div class="flex items-center gap-5">
                                <div class="h-12 w-12 rounded-xl flex items-center justify-center bg-[#E7BD8A]/10 text-[#E68757]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest">{{ $r->created_at->format('d M Y') }}</p>
                                    <h4 class="text-lg font-bold text-[#5B000B]">{{ $r->nama_galon }}</h4>
                                    <p class="text-sm font-black text-[#930014]">Rp{{ number_format($r->total_harga, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <a href="{{ route('galon.detail', $r->id) }}"
                                class="px-6 py-2 border border-[#E7BD8A] text-[#930014] text-[10px] font-bold rounded-full hover:bg-[#930014] hover:text-white transition-all uppercase tracking-widest">
                                Detail
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>