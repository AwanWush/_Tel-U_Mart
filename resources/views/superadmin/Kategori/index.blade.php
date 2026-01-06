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

        .text-dark-maroon {
            color: #5B000B;
        }

        .rounded-tj {
            border-radius: 1.5rem;
        }
    </style>

    <div class="py-9 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-[60px]">

            {{-- BREADCRUMB DASHBOARD --}}
            <nav class="flex items-center space-x-1 mb-4 text-sm font-bold text-gray-400">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-[#dc2626] transition-colors" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                    </svg>
                    <span class="tracking-wide">Dashboard</span>
                </a>
            </nav>

            {{-- HEADER SECTION: Judul & Tombol Tambah --}}
            <div class="flex flex-col md:flex-row justify-between items-start mb-3 gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">
                        Manajemen Kategori Global
                    </h2>
                    <p class="text-sm text-slate-500 font-medium italic mt-1">
                        Standardisasi kategori produk untuk seluruh unit TJ&TMart.
                    </p>
                </div>

                {{-- Tombol Tambah (Warna Dark Maroon #5B000B) --}}
                <button onclick="openModal('addKategoriModal')"
                    class="bg-[#5b000b] text-white py-2.5 px-6 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-[#b91c1c] transition-all shadow-lg shadow-red-200 flex items-center gap-2 active:scale-95 border-none">
                    <span class="text-lg">+</span> Tambah Kategori Baru
                </button>
            </div>

            {{-- TABLE SECTION --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-tj border border-red-100 mt-6">
                <div class="p-5 bg-dark-maroon text-white font-black flex justify-between items-center uppercase tracking-widest text-sm">
                    <span>Daftar Kategori Produk Aktif</span>
                    <span class="text-[10px] opacity-70">Total: {{ count($kategori) }} Kategori</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-red-50 text-red-700 uppercase text-[11px] font-black tracking-wider border-b border-red-100">
                            <tr>
                                <th class="px-6 py-4">ID Kategori</th>
                                <th class="px-6 py-4">Nama Kategori</th>
                                <th class="px-6 py-4 text-center">Aksi Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($kategori as $kat)
                            <tr class="hover:bg-red-50/50 transition group">
                                <td class="px-6 py-4 text-gray-400 font-mono text-xs">#KAT-0{{ $kat->id }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800 uppercase tracking-tight">{{ $kat->nama_kategori }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <button class="bg-blue-600 text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 active:scale-95 border-none transition-all shadow-sm">
                                            Edit
                                        </button>
                                        <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="bg-[#dc2626] text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 active:scale-95 border-none transition-all shadow-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KATEGORI --}}
    <div id="addKategoriModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeModal('addKategoriModal')"></div>
            
            <div class="inline-block bg-white rounded-tj text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border-t-8 border-dark-maroon z-50">
                <form action="{{ route('kategori.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-dark-maroon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Tambah Kategori</h3>
                    </div>

                    <div class="mb-6">
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Nama Kategori Produk</label>
                        <input type="text" name="nama_kategori" placeholder="E.g. MAKANAN RINGAN" 
                            class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm py-3 px-4 font-bold uppercase placeholder:text-gray-300 transition-all" required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('addKategoriModal')" 
                            class="px-6 py-2.5 bg-gray-100 text-gray-500 font-black rounded-xl hover:bg-gray-200 transition-all border-none text-[10px] uppercase tracking-widest">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-2.5 bg-[#dc2626] text-white font-black uppercase text-[10px] tracking-widest rounded-xl hover:bg-red-700 shadow-lg shadow-red-200 active:scale-95 border-none transition-all">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function openModal(id) { 
            document.getElementById(id).classList.remove('hidden'); 
            document.body.style.overflow = 'hidden'; 
        }
        function closeModal(id) { 
            document.getElementById(id).classList.add('hidden'); 
            document.body.style.overflow = 'auto'; 
        }
    </script>
</x-app-layout>