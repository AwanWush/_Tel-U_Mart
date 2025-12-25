<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-tight">
            {{ __('Tentang Kami') }}
        </h2>
    </x-slot>

    <div class="pt-6 pb-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Banner Section --}}
            <div class="relative overflow-hidden rounded-[2rem] bg-[#5B000B] text-white p-8 md:p-16 mb-8 shadow-xl">
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight uppercase tracking-tighter">
                        Solusi Kebutuhan Asramamu.
                    </h1>
                    <p class="text-sm md:text-base opacity-90 leading-relaxed font-medium">
                        TJ&TMart hadir sebagai pusat perbelanjaan terintegrasi di lingkungan asrama. Kami memahami dinamika kehidupan mahasiswa, itulah sebabnya kami menyediakan layanan yang cepat, dekat, dan lengkap.
                    </p>
                </div>
                {{-- Dekorasi Abstract --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                {{-- Card Visi --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="text-xl">🎯</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 uppercase text-sm tracking-wide">Visi Kami</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Menjadi ekosistem retail asrama terbaik yang memberikan kenyamanan maksimal bagi setiap mahasiswa melalui teknologi dan layanan prima.</p>
                </div>

                {{-- Card Layanan --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="text-xl">⚡</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 uppercase text-sm tracking-wide">Layanan Cepat</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Dari token listrik hingga galon asrama, semua pesanan diproses secara real-time untuk memastikan kebutuhanmu terpenuhi tanpa hambatan.</p>
                </div>

                {{-- Card Keamanan --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="text-xl">🛡️</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 uppercase text-sm tracking-wide">Transaksi Aman</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Sistem pembayaran dan pengelolaan stok yang transparan di setiap cabang TJ Mart Putra maupun Putri.</p>
                </div>
            </div>

            {{-- Info Mart Section --}}
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 tracking-tight">Menjangkau Seluruh Penjuru Asrama</h2>
                        <p class="text-sm text-gray-500 leading-loose mb-6">
                            Kami mengoperasikan berbagai titik distribusi strategis termasuk <strong>TJ Mart Putra</strong> dan <strong>TJ Mart Putri</strong> untuk memastikan jarak bukan lagi masalah. Setiap mart dikelola secara profesional dengan standar kualitas produk yang terjaga.
                        </p>
                        <div class="flex gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-black text-[#5B000B]">12</p>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Kategori</p>
                            </div>
                            <div class="border-l border-gray-200 mx-2"></div>
                            <div class="text-center">
                                <p class="text-2xl font-black text-[#5B000B]">500+</p>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Produk</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 w-full">
                        <img src="https://images.unsplash.com/photo-1534723452862-4c874018d66d?auto=format&fit=crop&q=80&w=800" class="rounded-2xl shadow-lg w-full h-48 object-cover" alt="Mart Interior">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>