<x-app-layout>
    <x-slot name="header">
        <h2 class="font-light text-xl text-[#5B000B] leading-tight">
            Pesanan Berhasil
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[2rem] p-10 border border-[#E7BD8A]/20">

                {{-- HEADER --}}
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-[#930014]/5 text-[#930014] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-light text-[#5B000B]">
                        Terima <span class="font-bold">Kasih!</span>
                    </h3>
                    <p class="text-gray-400 text-sm mt-1">
                        Pesanan Anda sedang diproses oleh tim kami.
                    </p>
                </div>

                {{-- DETAIL PESANAN --}}
                <div class="space-y-4">

                    {{-- ROW 1 --}}
                    <div class="p-5 rounded-xl bg-gray-50 border border-gray-100">
                        <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">
                            Jenis Pesanan
                        </p>
                        <p class="text-base font-bold text-[#5B000B]">
                            {{ $transaksi->nama_galon }}
                        </p>
                    </div>

                    {{-- ROW 2 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">Jumlah</p>
                            <p class="text-sm font-bold text-[#5B000B]">{{ $transaksi->jumlah }} Galon</p>
                        </div>

                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">Harga Satuan</p>
                            <p class="text-sm font-bold text-[#5B000B]">
                                Rp{{ number_format($transaksi->harga_satuan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- ROW 3 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">Waktu Transaksi</p>
                            <p class="text-sm font-bold text-[#5B000B]">{{ $transaksi->waktu_transaksi }}</p>
                        </div>

                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-2">Status</p>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold text-white
                                @if($transaksi->status === 'pending') bg-yellow-500
                                @elseif($transaksi->status === 'diproses') bg-blue-500
                                @elseif($transaksi->status === 'selesai') bg-green-600
                                @else bg-gray-400 @endif">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- ROW 4 : TOTAL + ACTION --}}
                    <div class="p-6 rounded-2xl bg-[#930014]/5 border border-[#930014]/20 space-y-5">
                        <div>
                            <p class="text-[9px] font-bold text-[#E68757] uppercase tracking-widest mb-1">
                                Total Pembayaran
                            </p>
                            <p class="text-2xl font-black text-[#930014]">
                                Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- ACTION BUTTON --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-[#930014]/20">
                            <a href="{{ route('galon.index') }}"
                            class="px-4 py-3 border border-[#E7BD8A] text-[#930014] rounded-xl text-center text-xs font-bold uppercase tracking-widest hover:bg-white transition-all">
                                Pesan Lagi
                            </a>

                            <a href="{{ route('dashboard') }}"
                            class="px-4 py-3 bg-[#930014] text-white rounded-xl text-center text-xs font-bold uppercase tracking-widest hover:bg-[#5B000B] transition-all shadow-lg">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>