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

    <div 
        x-data="{
            loading: false,
            preview: null,
            fileChosen(event) {
                const file = event.target.files[0];
                if (file) {
                    this.preview = URL.createObjectURL(file);
                } else {
                    this.preview = null;
                }
            }
        }"
        class="py-12 bg-gray-50 min-h-screen"
    >
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
                <span class="text-gray-600">Tambah Baru</span>
            </nav>

            <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100">
                {{-- HEADER FORM --}}
                <div class="bg-dark-maroon p-6 text-white">
                    <h2 class="text-xl font-black uppercase tracking-widest flex items-center gap-3">
                        <i class="fas fa-plus-circle text-[#E7BD8A]"></i> Registrasi Produk Baru
                    </h2>
                    <p class="text-[10px] text-red-200 uppercase tracking-[0.2em] mt-1 font-bold">Lengkapi rincian inventori produk di bawah ini</p>
                </div>

                {{-- Notifikasi --}}
                <div class="px-8 pt-6">
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl text-sm font-bold mb-4 shadow-sm">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl text-sm font-bold mb-4 shadow-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Mohon periksa kembali input Anda.
                        </div>
                    @endif
                </div>

                <form 
                    action="{{ route('admin.produk.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                    @submit="loading = true"
                    class="p-8 space-y-6"
                >
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Produk --}}
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="nama_produk" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_produk" name="nama_produk" required value="{{ old('nama_produk') }}"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3 transition-all @error('nama_produk') border-red-500 @enderror"
                                placeholder="E.g. Indomie Goreng Spesial">
                        </div>
                        
                        {{-- Kategori --}}
                        <div class="space-y-1.5">
                            <label for="kategori_id" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Kategori Produk <span class="text-red-500">*</span></label>
                            <select id="kategori_id" name="kategori_id" required
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3 @error('kategori_id') border-red-500 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="space-y-1.5">
                            <label for="status_ketersediaan" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Status Ketersediaan <span class="text-red-500">*</span></label>
                            <select id="status_ketersediaan" name="status_ketersediaan" required
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3">
                                <option value="Tersedia" {{ old('status_ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Habis" {{ old('status_ketersediaan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="space-y-1.5">
                            <label for="harga" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" id="harga" name="harga" required value="{{ old('harga') }}"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3 @error('harga') border-red-500 @enderror"
                                placeholder="3500">
                        </div>

                        {{-- Stok --}}
                        <div class="space-y-1.5">
                            <label for="stok" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" id="stok" name="stok" required value="{{ old('stok') }}"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3 @error('stok') border-red-500 @enderror"
                                placeholder="100">
                        </div>
                    </div>

                    {{-- Mart Selection --}}
                    <div class="space-y-1.5">
                        <label for="mart_id" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Penempatan Unit Mart <span class="text-red-500">*</span></label>
                        <select id="mart_id" name="mart_id[]" multiple required
                            class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm min-h-[120px] p-2 @error('mart_id') border-red-500 @enderror">
                            @foreach($mart as $m)
                                <option value="{{ $m->id }}" {{ in_array($m->id, old('mart_id', [])) ? 'selected' : '' }}>
                                    {{ $m->nama_mart }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-400 italic mt-1 font-medium">* Tahan CTRL untuk memilih lebih dari satu mart.</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="space-y-1.5">
                        <label for="deskripsi" class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Deskripsi Produk</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] font-bold text-sm py-3 px-4 @error('deskripsi') border-red-500 @enderror"
                                placeholder="Jelaskan detail singkat produk...">{{ old('deskripsi') }}</textarea>
                    </div>
                    
                    {{-- Gambar --}}
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Gambar Produk</label>
                        <div class="flex items-center gap-6 p-6 border-2 border-dashed border-gray-100 rounded-3xl bg-gray-50/50">
                            <div class="shrink-0">
                                <template x-if="preview">
                                    <img :src="preview" x-transition.opacity
                                         class="h-28 w-28 object-cover rounded-2xl shadow-lg border-2 border-white ring-1 ring-gray-200">
                                </template>
                                <template x-if="!preview">
                                    <div class="h-28 w-28 rounded-2xl bg-white flex items-center justify-center text-gray-300 border border-gray-100 shadow-inner">
                                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="inline-flex cursor-pointer bg-white py-2.5 px-5 border border-gray-200 rounded-xl shadow-sm text-xs font-black uppercase tracking-widest text-gray-700 hover:bg-[#dc2626] hover:text-white transition-all duration-200 active:scale-95">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Pilih Gambar
                                    <input type="file" name="gambar" id="gambar" accept="image/*" class="sr-only" @change="fileChosen($event)">
                                </label>
                                <p class="text-[10px] text-gray-400 font-medium italic">Format: JPG, PNG, WEBP (Max. 2MB)</p>
                            </div>
                        </div>
                        @error('gambar')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-gray-50">
                        <button 
                            type="submit"
                            class="flex-[2] bg-[#dc2626] hover:bg-[#b91c1c] text-white font-black uppercase text-xs tracking-[0.2em] py-4 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center gap-3 shadow-lg shadow-red-100 active:scale-[0.98]"
                            :disabled="loading"
                        >
                            <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            <span x-text="loading ? 'Sedang Memproses...' : 'Daftarkan Produk Sekarang'"></span>
                        </button>

                        <a href="{{ route('admin.produk.index') }}"
                           class="flex-1 bg-white border border-gray-200 text-gray-500 font-black uppercase text-xs tracking-widest py-4 px-6 rounded-2xl text-center hover:bg-gray-50 transition-all">
                           Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>