<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-tight">
            {{ __('Pertanyaan Sering Diajukan (FAQ)') }}
        </h2>
    </x-slot>

    <div class="pt-4 pb-12 bg-gray-50 min-h-screen font-sans" x-data="{ active: null }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header FAQ --}}
            <div class="text-center mb-10 px-4">
                <h1 class="text-2xl font-black text-[#5B000B] uppercase tracking-tighter">Butuh Bantuan Cepat?</h1>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">Cari jawaban untuk kendala umum kamu di sini</p>
            </div>

            <div class="space-y-3">
                {{-- FAQ Item 1 --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full px-6 py-4 text-left flex justify-between items-center transition-all hover:bg-gray-50">
                        <span class="text-sm font-bold text-gray-800">Bagaimana cara memesan Air Galon Asrama?</span>
                        <svg class="w-5 h-5 text-[#5B000B] transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-4">
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Kamu bisa memesan melalui menu "Galon" di dashboard atau langsung klik tombol WhatsApp darurat di halaman Kontak. Pesanan akan diantar langsung ke depan kamar kamu.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full px-6 py-4 text-left flex justify-between items-center transition-all hover:bg-gray-50">
                        <span class="text-sm font-bold text-gray-800">Apakah token listrik tersedia setiap saat?</span>
                        <svg class="w-5 h-5 text-[#5B000B] transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-4">
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Ya, sistem token listrik terintegrasi 24 jam. Kamu bisa melakukan pembelian mandiri lewat menu "Token Listrik" dan kode akan muncul secara otomatis setelah pembayaran dikonfirmasi.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-4 text-left flex justify-between items-center transition-all hover:bg-gray-50">
                        <span class="text-sm font-bold text-gray-800">Apa itu fitur Prioritas Toko?</span>
                        <svg class="w-5 h-5 text-[#5B000B] transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-6 pb-4">
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Fitur ini memungkinkan kamu memilih mart terdekat (Putra/Putri) agar stok dan harga yang ditampilkan sesuai dengan ketersediaan di gedung asramamu.
                        </p>
                    </div>
                </div>

                {{-- FAQ Item 4 --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <button @click="active = (active === 4 ? null : 4)" class="w-full px-6 py-4 text-left flex justify-between items-center transition-all hover:bg-gray-50">
                        <span class="text-sm font-bold text-gray-800">Bagaimana jika pesanan saya belum sampai?</span>
                        <svg class="w-5 h-5 text-[#5B000B] transition-transform duration-300" :class="active === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 4" x-collapse class="px-6 pb-4">
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Silakan cek status di menu "Pesanan Saya". Jika dalam 30 menit pesanan belum diproses, kamu bisa menghubungi admin mart gedung melalui halaman Kontak.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Call to Action --}}
            <div class="mt-10 bg-[#5B000B] rounded-3xl p-8 text-white text-center shadow-lg shadow-red-100">
                <h4 class="font-bold text-lg mb-2 uppercase tracking-tighter">Masih punya pertanyaan lain?</h4>
                <p class="text-xs opacity-80 mb-6">Tim admin kami siap membantu kendala kamu setiap hari.</p>
                <a href="{{ route('kontak.index') }}" class="inline-block bg-white text-[#5B000B] px-8 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest active:scale-95 transition-all">
                    Hubungi Admin &rarr;
                </a>
            </div>
        </div>
    </div>

    <style>
        .font-sans { font-family: 'Inter', sans-serif !important; }
    </style>
</x-app-layout>