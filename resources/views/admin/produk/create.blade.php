<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            Tambah Produk Baru
        </h2>
    </x-slot>

    <div 
        x-data="{
            loading: false,
            preview: null,
            // Fungsi untuk menampilkan gambar saat dipilih
            fileChosen(event) {
                const file = event.target.files[0];
                if (file) {
                    this.preview = URL.createObjectURL(file);
                } else {
                    this.preview = null;
                }
            }
        }"
        class="py-8 max-w-4xl mx-auto"
    >
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
            
            {{-- Form Status/Error Message (Optional: Tambahkan di sini jika ada error umum) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline"> Mohon periksa kembali input Anda.</span>
                </div>
            @endif

            <form 
                action="{{ route('admin.produk.store') }}" 
                method="POST" 
                enctype="multipart/form-data"
                @submit="loading = true"
            >
                @csrf

                <div class="mb-6">
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_produk" name="nama_produk" required value="{{ old('nama_produk') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3 @error('nama_produk') border-red-500 @enderror">
                    @error('nama_produk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori Produk <span class="text-red-500">*</span></label>
                    <select id="kategori_id" name="kategori_id" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3 @error('kategori_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-6">
                    <label for="mart_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Mart (Bisa pilih lebih dari satu) <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="mart_id"
                        name="mart_id[]" 
                        multiple 
                        required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3 h-32 @error('mart_id') border-red-500 @enderror"
                    >
                        @foreach($mart as $m)
                            <option value="{{ $m->id }}" {{ in_array($m->id, old('mart_id', [])) ? 'selected' : '' }}>
                                {{ $m->nama_mart }}
                            </option>
                        @endforeach
                    </select>
                    @error('mart_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">
                     Tahan Ctrl untuk memilih Mart lebih dari satu.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="harga" name="harga" required value="{{ old('harga') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3 @error('harga') border-red-500 @enderror">
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                        <input type="number" id="stok" name="stok" required value="{{ old('stok') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3 @error('stok') border-red-500 @enderror">
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Letakkan di bawah input Stok --}}
                <div class="mb-6">
                    <label for="status_ketersediaan" class="block text-sm font-medium text-gray-700 mb-1">Status Ketersediaan <span class="text-red-500">*</span></label>
                    <select id="status_ketersediaan" name="status_ketersediaan" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3">
                        <option value="Tersedia" {{ old('status_ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Habis" {{ old('status_ketersediaan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 p-3 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-8">
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <div class="mt-1 flex items-center gap-4">
                        <div class="shrink-0">
                            <template x-if="preview">
                                <img :src="preview" x-transition.opacity
                                     class="h-24 w-24 object-cover rounded-lg shadow-md border-2 border-gray-200">
                            </template>
                            <template x-if="!preview">
                                <div class="h-24 w-24 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                        
                        <label class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Pilih Gambar
                            <input 
                                type="file" 
                                name="gambar"
                                id="gambar"
                                accept="image/*"
                                class="sr-only"
                                @change="fileChosen($event)"
                            >
                        </label>
                    </div>
                    @error('gambar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition ease-in-out duration-150 flex items-center justify-center gap-3 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    :disabled="loading"
                >
                    <svg x-show="loading" class="animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>

                    <span x-text="loading ? 'Sedang Menyimpan Produk...' : 'Simpan Produk'"></span>
                </button>
            </form>
        </div>
    </div>
</x-app-layout>