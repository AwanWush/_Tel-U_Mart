<x-app-layout>
    <style>
        /* Menghilangkan outline biru/putih saat klik tombol */
        button:focus,
        a:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .bg-dark-maroon {
            background-color: #5B000B;
        }

        .text-tj-red {
            color: #dc2626;
        }

        .bg-tj-red {
            background-color: #dc2626;
        }

        /* Mengurangi padding atas agar tidak terlalu jauh ke bawah */
        .main-container {
            padding-top: 1.5rem;
        }
    </style>

    <div class="main-container bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-8">

            <div class="flex align left pt-[70px] mb-4">
                <nav class="flex items-center space-x-1 mb-0 text-sm font-bold text-gray-500">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#dc2626] transition-colors"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                        </svg>
                        <span class="tracking-wide">Dashboard</span>
                    </a>
                </nav>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-2 px-0">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">
                        Kelola Unit Mart
                    </h2>
                    <p class="text-sm text-gray-500 font-medium">Manajemen operasional seluruh cabang TJ&TMart</p>
                </div>

                <button onclick="openModal('addMartModal')"
                    class="mt-4 md:mt-0 bg-[#5b000b] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md active:scale-95 transition-all duration-200 flex items-center justify-center border-none">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Unit Mart
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-dark-maroon text-white">
                                <th class="px-6 py-4 uppercase text-[11px] font-black tracking-wider">Nama Mart</th>
                                <th class="px-6 py-4 uppercase text-[11px] font-black tracking-wider">Alamat Lokasi</th>
                                <th class="px-6 py-4 uppercase text-[11px] font-black tracking-wider text-center">Status
                                </th>
                                <th class="px-6 py-4 uppercase text-[11px] font-black tracking-wider text-center">
                                    Kontrol Akses</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($marts as $mart)
                                <tr class="hover:bg-red-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 leading-none">{{ $mart->nama_mart }}</div>
                                        <div class="text-[10px] text-tj-red font-black mt-1">ID: #00{{ $mart->id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 leading-snug max-w-md">
                                            {{ $mart->alamat ?? 'Alamat belum dikonfigurasi' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $mart->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $mart->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <form action="{{ route('superadmin.mart.toggle', $mart->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    class="text-[10px] font-black uppercase px-4 py-2 rounded-lg transition-all border-none {{ $mart->is_active ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                                    {{ $mart->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <button
                                                onclick="editMart({{ $mart->id }}, '{{ $mart->nama_mart }}', '{{ $mart->alamat }}')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase transition-all border-none">
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium">Belum
                                        ada unit mart terdaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="addMartModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                onclick="closeModal('addMartModal')"></div>

            <div
                class="inline-block bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border-t-8 border-tj-red z-50">
                <div class="bg-white px-6 py-8">
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-1">Registrasi Mart</h3>
                    <p class="text-sm text-gray-500 mb-6 font-medium">Tambahkan unit baru ke dalam sistem distribusi.
                    </p>

                    <form action="{{ route('superadmin.mart.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-black text-gray-700 uppercase mb-1">Nama Unit
                                Mart</label>
                            <input type="text" name="nama_mart"
                                class="w-full border-gray-200 rounded-xl focus:ring-tj-red focus:border-tj-red text-sm py-3 px-4"
                                required>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-700 uppercase mb-1">Alamat
                                Lengkap</label>
                            <textarea name="alamat" rows="3"
                                class="w-full border-gray-200 rounded-xl focus:ring-tj-red focus:border-tj-red text-sm px-4"></textarea>
                        </div>
                        <input type="hidden" name="is_active" value="1">

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" onclick="closeModal('addMartModal')"
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all border-none">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-tj-red text-white font-black uppercase text-xs rounded-xl hover:bg-red-700 shadow-lg active:scale-95 transition-all border-none">
                                Simpan Unit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="editMartModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                onclick="closeModal('editMartModal')"></div>
            <div
                class="inline-block bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border-t-8 border-blue-600 z-50">
                <div class="bg-white px-6 py-8 text-left">
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-1">Edit Unit Mart</h3>
                    <p class="text-sm text-gray-500 mb-6 font-medium">Perbarui informasi unit mart yang sudah ada.</p>
                    <form id="editForm" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[11px] font-black text-gray-700 uppercase mb-1">Nama Unit
                                Mart</label>
                            <input type="text" name="nama_mart" id="edit_nama_mart"
                                class="w-full border-gray-200 rounded-xl focus:ring-blue-600 focus:border-blue-600 text-sm py-3 px-4"
                                required>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-700 uppercase mb-1">Alamat
                                Lengkap</label>
                            <textarea name="alamat" id="edit_alamat" rows="3"
                                class="w-full border-gray-200 rounded-xl focus:ring-blue-600 focus:border-blue-600 text-sm px-4"></textarea>
                        </div>
                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" onclick="closeModal('editMartModal')"
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all border-none">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 text-white font-black uppercase text-xs rounded-xl hover:bg-blue-700 shadow-lg active:scale-95 transition-all border-none">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
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

        function editMart(id, nama, alamat) {
            const form = document.getElementById('editForm');
            form.action = `/superadmin/kelola-mart/update/${id}`;
            document.getElementById('edit_nama_mart').value = nama;
            document.getElementById('edit_alamat').value = alamat;
            openModal('editMartModal');
        }
    </script>
</x-app-layout>
