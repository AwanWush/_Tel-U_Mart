<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Produk</h2>
    </x-slot>

    <div x-data="{ loading: false, preview: null }" class="py-6 max-w-4xl mx-auto">
        <div class="bg-white rounded shadow p-6">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" @submit="loading = true">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" required class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Kategori</label>
                    <select name="kategori_id" required class="w-full border rounded p-2">
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Mart (Bisa pilih lebih dari satu)</label>
                    <select name="mart_id[]" multiple required class="w-full border rounded p-2 h-20">
                        @foreach($mart as $m)
                            <option value="{{ $m->id }}" {{ in_array($m->id, $produk->marts->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $m->nama_mart }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Tahan Ctrl (Windows) untuk pilih banyak</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium">Harga</label>
                        <input type="number" name="harga" value="{{ $produk->harga }}" required class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Stok</label>
                        <input type="number" name="stok" value="{{ $produk->stok }}" required class="w-full border rounded p-2">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border rounded p-2">{{ $produk->deskripsi }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Gambar</label>
                    <input type="file" name="gambar" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])">

                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="mt-3 h-32 rounded shadow">
                    @endif

                    <template x-if="preview">
                        <img :src="preview" class="mt-3 h-32 rounded shadow">
                    </template>
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded flex items-center gap-2" :disabled="loading">
                    <span x-text="loading ? 'Menyimpan...' : 'Update Produk'"></span>
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
