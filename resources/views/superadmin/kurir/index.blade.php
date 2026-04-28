<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-[60px]">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-[#5B000B] uppercase tracking-tighter">Kelola Personel Kurir</h2>
                    <p class="text-gray-500 font-medium">Daftarkan dan hubungkan kurir ke aplikasi Driver Android.</p>
                </div>
                <button onclick="openModal('modalTambahKurir')"
                    class="bg-[#dc2626] hover:bg-[#5B000B] text-white px-6 py-3 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-lg active:scale-95">
                    <i class="fas fa-plus mr-2"></i> Tambah Kurir Baru
                </button>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-r-xl">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Kurir</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Email (Login App)
                            </th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">No. Telepon</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($kurirs as $kurir)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ substr($kurir->name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-800">{{ $kurir->name }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-gray-600 font-medium">{{ $kurir->email }}</td>
                                <td class="p-6 text-gray-600 font-medium">{{ $kurir->no_telp ?? '-' }}</td>
                                <td class="p-6 text-center">
                                    <form action="{{ route('superadmin.kurir.destroy', $kurir->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus kurir ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700 transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-gray-400 font-medium">Belum ada kurir
                                    yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KURIR --}}
    <div id="modalTambahKurir" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                onclick="closeModal('modalTambahKurir')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('superadmin.kurir.store') }}" method="POST" class="p-8">
                    @csrf
                    <h3 class="text-2xl font-black text-[#5B000B] uppercase tracking-tighter mb-6">Pendaftaran Kurir
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nama
                                Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full rounded-xl border-gray-200 focus:border-[#dc2626] focus:ring-[#dc2626]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Email
                                (Untuk Login Android)</label>
                            <input type="email" name="email" required
                                class="w-full rounded-xl border-gray-200 focus:border-[#dc2626] focus:ring-[#dc2626]">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full rounded-xl border-gray-200 focus:border-[#dc2626] focus:ring-[#dc2626]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">No.
                                WhatsApp/Telepon</label>
                            <input type="text" name="no_telp" required
                                class="w-full rounded-xl border-gray-200 focus:border-[#dc2626] focus:ring-[#dc2626]">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Pilih
                                Bank</label>
                            <select name="nama_bank" required
                                class="w-full rounded-xl border-gray-200 focus:border-[#dc2626] focus:ring-[#dc2626]">
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA">BCA</option>
                                <option value="MANDIRI">MANDIRI</option>
                                <option value="BRI">BRI</option>
                                <option value="BNI">BNI</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nomor
                                Rekening</label>
                            <input type="number" name="nomor_rekening" required placeholder="Masukkan nomor rekening"
                                class="w-full rounded-xl border-gray-200 focus:border-[#dc2626] focus:ring-[#dc2626]">
                            <small class="text-gray-400">Pastikan nomor rekening belum pernah terdaftar.</small>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-[#dc2626] text-white py-4 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-[#5B000B] transition">Simpan
                            & Daftarkan</button>
                        <button type="button" onclick="closeModal('modalTambahKurir')"
                            class="px-6 py-4 border-2 border-gray-100 rounded-xl font-black uppercase text-xs tracking-widest text-gray-400 hover:bg-gray-50">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
</x-app-layout>
