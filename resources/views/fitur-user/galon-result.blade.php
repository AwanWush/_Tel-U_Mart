<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-[#5B000B] leading-tight">
            Pesanan Berhasil
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[2rem] p-10 border border-[#E7BD8A]/20">
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-[#930014]/5 text-[#930014] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-light text-[#5B000B]">Terima <span class="font-bold">Kasih!</span></h3>
                    <p class="text-gray-400 text-sm mt-1">Pesanan Anda sedang diproses oleh tim kami.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">Item</p>
                        <p class="text-sm font-bold text-[#5B000B]">{{ $transaksi->nama_galon }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">Total</p>
                        <p class="text-sm font-bold text-[#930014]">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('galon.index') }}"
                        class="flex-1 px-4 py-3 border border-[#E7BD8A] text-[#930014] rounded-xl text-center text-xs font-bold uppercase tracking-widest hover:bg-gray-50 transition-all">
                        Pesan Lagi
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 px-4 py-3 bg-[#930014] text-white rounded-xl text-center text-xs font-bold uppercase tracking-widest hover:bg-[#5B000B] transition-all shadow-lg">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>