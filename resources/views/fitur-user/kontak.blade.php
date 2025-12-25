<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-tight">
            {{ __('Kontak & Bantuan') }}
        </h2>
    </x-slot>

    <div class="pt-4 pb-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-6">
                
                {{-- Sidebar Info --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="text-[#5B000B] font-bold text-sm uppercase tracking-widest mb-4">Saluran Bantuan</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-red-50 rounded-lg text-lg">📞</div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">WhatsApp CS</p>
                                    <p class="text-sm font-bold text-gray-800">+62 812-3456-7890</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-blue-50 rounded-lg text-lg">📧</div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Email Dukungan</p>
                                    <p class="text-sm font-bold text-gray-800">help@tjtmart.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="text-[#5B000B] font-bold text-sm uppercase tracking-widest mb-4">Lokasi Mart</h3>
                        <div class="space-y-4">
                            <div class="group cursor-pointer">
                                <p class="text-xs font-bold text-gray-800 group-hover:text-[#5B000B] transition-colors">TJ Mart Putra</p>
                                <p class="text-[11px] text-gray-500 leading-tight mt-1">Gedung Asrama Putra Blok A, Lt. Dasar</p>
                            </div>
                            <div class="group cursor-pointer">
                                <p class="text-xs font-bold text-gray-800 group-hover:text-[#5B000B] transition-colors">TJ Mart Putri</p>
                                <p class="text-[11px] text-gray-500 leading-tight mt-1">Gedung Asrama Putri Blok D, Lt. 1</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#5B000B] p-6 rounded-2xl text-white shadow-lg relative overflow-hidden">
                        <h4 class="font-bold text-sm mb-2 relative z-10">Butuh Galon atau Token?</h4>
                        <p class="text-[11px] opacity-80 mb-4 relative z-10 leading-relaxed">Layanan khusus pemesanan galon asrama dan token listrik tersedia 24 jam untuk penghuni.</p>
                        <a href="https://wa.me/6281234567890" class="inline-block bg-white text-[#5B000B] px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest relative z-10 active:scale-95 transition-transform">Hubungi Sekarang</a>
                        <span class="absolute -right-4 -bottom-4 text-6xl opacity-10">💧</span>
                    </div>
                </div>

                {{-- Form Kontak --}}
                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 tracking-tight">Kirim Pesan atau Keluhan</h3>
                        <form action="#" class="space-y-4">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                    <input type="text" class="w-full bg-gray-50 border-gray-100 rounded-xl focus:ring-[#5B000B] focus:border-[#5B000B] text-sm py-3 transition-all" placeholder="Masukkan nama Anda">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Kategori Masalah</label>
                                    <select class="w-full bg-gray-50 border-gray-100 rounded-xl focus:ring-[#5B000B] focus:border-[#5B000B] text-sm py-3 transition-all">
                                        <option>Pertanyaan Umum</option>
                                        <option>Masalah Token Listrik</option>
                                        <option>Layanan Air Galon</option>
                                        <option>Keluhan Produk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Isi Pesan</label>
                                <textarea rows="5" class="w-full bg-gray-50 border-gray-100 rounded-xl focus:ring-[#5B000B] focus:border-[#5B000B] text-sm py-3 transition-all" placeholder="Ceritakan detail kendala Anda..."></textarea>
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="w-full md:w-auto px-10 py-3 bg-[#5B000B] text-white rounded-xl text-xs font-bold uppercase tracking-[0.2em] shadow-lg shadow-red-100 hover:brightness-110 active:scale-95 transition-all">
                                    Kirim Sekarang &rarr;
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>