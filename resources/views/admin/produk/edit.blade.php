<x-app-layout>
    <style>
        button:focus,
        a:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        .bg-dark-maroon {
            background-color: #5B000B;
        }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-[60px]">
            
            {{-- BREADCRUMB --}}
            <nav class="flex items-center space-x-1 mb-6 text-sm font-bold text-gray-400">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-[#dc2626]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <span class="text-gray-300">/</span>
                <a href="{{ route('admin.produk.index') }}" class="hover:text-[#dc2626]">Produk</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600">Edit</span>
            </nav>

            <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100">
                {{-- HEADER FORM --}}
                <div class="bg-[#5B000B] p-6 text-white">
                    <h2 class="text-xl font-black uppercase tracking-widest flex items-center gap-3">
                        <i class="fas fa-edit text-[#E7BD8A]"></i> Edit Detail Produk
                    </h2>
                    <p class="text-[10px] text-red-200 uppercase tracking-[0.2em] mt-1 font-bold">Pastikan data inventori sudah akurat</p>
                </div>

                <form action="{{ route('admin.produk.update', $produk->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-8 space-y-6">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Produk --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama Produk</label>
                            <input type="text" name="nama_produk" 
                                   value="{{ old('nama_produk', $produk->nama_produk) }}"
                                   class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3" required>
                        </div>

                        {{-- Kategori --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Kategori Produk</label>
                            <select name="kategori_id" class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3">
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Harga Jual (Rp)</label>
                            <input type="number" name="harga" 
                                   value="{{ old('harga', $produk->harga) }}"
                                   class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3" required>
                        </div>

                        {{-- Stok --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Jumlah Stok</label>
                            <input type="number" name="stok" 
                                   value="{{ old('stok', $produk->stok) }}"
                                   class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3" required>
                        </div>
                    </div>

                    {{-- Mart Selection --}}
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Penempatan Unit Mart</label>
                        <select name="mart_id[]" multiple
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm min-h-[100px] p-2">
                            @foreach ($mart as $m)
                                <option value="{{ $m->id }}" {{ $produk->marts->contains($m->id) ? 'selected' : '' }}>
                                    {{ $m->nama_mart }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-400 italic mt-1 font-medium">* Tahan tombol CTRL untuk memilih lebih dari satu mart.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                        {{-- Status --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Status Ketersediaan</label>
                            <select name="status_ketersediaan" class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3">
                                <option value="Tersedia" {{ $produk->status_ketersediaan == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Habis" {{ $produk->status_ketersediaan == 'Habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>

                        {{-- Gambar --}}
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Gambar Produk</label>
                            <div class="flex items-center gap-4 p-4 border-2 border-dashed border-gray-100 rounded-2xl">
                                @if ($produk->gambar)
                                    <img src="{{ asset($produk->gambar) }}" class="w-20 h-20 object-cover rounded-xl border shadow-sm">
                                @endif
                                <input type="file" name="gambar" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-red-50 file:text-[#dc2626] hover:file:bg-red-100 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end items-center gap-4 pt-6 border-t border-gray-50">
                        <a href="{{ route('admin.produk.index') }}"
                           class="px-6 py-3 text-[11px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition">
                           Batal
                        </a>

                        <button type="submit"
                                class="px-8 py-3 bg-[#dc2626] text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-[#b91c1c] transition-all shadow-lg shadow-red-100 active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>