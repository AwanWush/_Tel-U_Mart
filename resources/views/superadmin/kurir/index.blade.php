<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-[60px]">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-[#5B000B] uppercase tracking-tighter">Kelola Personel Kurir</h2>
                    <p class="text-gray-500 font-medium">Daftarkan dan hubungkan kurir ke aplikasi Driver Android.</p>
                </div>
                <button type="button" id="btnTambahKurir"
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
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-bold rounded-r-xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Kurir</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">
                                Status</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Email</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">No. Telepon</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Bank</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">No. Rekening</th>
                            <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($kurirs as $kurir)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                            @if ($kurir->gambar)
                                                <img src="{{ asset('storage/' . $kurir->gambar) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                                    {{ substr($kurir->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <span class="font-bold text-gray-800">{{ $kurir->name }}</span>
                                    </div>
                                </td>

                                {{-- LOGIKA STATUS AKUN --}}
                                <td class="p-6 text-center">
                                    @if ($kurir->status == 'aktif')
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase rounded-full">Aktif</span>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black uppercase rounded-full">Nonaktif</span>
                                            <span class="text-[9px] text-red-400 font-bold mt-1">Mangkir 3 Hari</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="p-6 text-gray-600 font-medium">{{ $kurir->email }}</td>
                                <td class="p-6 text-gray-600 font-medium">{{ $kurir->no_telp ?? '-' }}</td>
                                <td class="p-6">
                                    @if ($kurir->admin && $kurir->admin->nama_bank)
                                        <span
                                            class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-lg uppercase tracking-widest">
                                            {{ $kurir->admin->nama_bank }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-6 text-gray-600 font-medium font-mono">
                                    {{ $kurir->admin->nomor_rekening ?? '-' }}
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center gap-3">

                                        {{-- LOGIKA TOMBOL AKTIFKAN KEMBALI --}}
                                        @if ($kurir->status == 'nonaktif')
                                            <form action="{{ route('superadmin.kurir.aktifkan', $kurir->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-orange-500 hover:text-orange-700 transition"
                                                    title="Aktifkan Kembali">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button"
                                            onclick="bukaModalEdit(
                                    {{ $kurir->id }},
                                    '{{ addslashes($kurir->name) }}',
                                    '{{ $kurir->email }}',
                                    '{{ $kurir->no_telp }}',
                                    '{{ $kurir->admin->nama_bank ?? '' }}',
                                    '{{ $kurir->admin->nomor_rekening ?? '' }}'
                                )"
                                            class="text-blue-500 hover:text-blue-700 transition">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('superadmin.kurir.destroy', $kurir->id) }}"
                                            method="POST" onsubmit="return confirm('Hapus kurir ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-gray-400 italic">Belum ada kurir yang
                                    terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH KURIR --}}
    <div id="modalTambahKurir" class="fixed inset-0 z-[9999] hidden" style="background: rgba(0,0,0,0.5);">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-[2rem] shadow-xl w-full max-w-lg relative">

                <form action="{{ route('superadmin.kurir.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-8">
                    @csrf

                    <h3 class="text-2xl font-black text-[#5B000B] mb-6">
                        Pendaftaran Kurir
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <input type="text" name="name" placeholder="Nama"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <input type="email" name="email" placeholder="Email"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <input type="password" name="password" placeholder="Password (min. 8 karakter)"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required minlength="8">
                        </div>

                        <div>
                            <input type="text" name="no_telp" placeholder="No HP"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 font-bold uppercase tracking-widest ml-1">Foto
                                Profil</label>
                            <input type="file" name="foto" accept="image/*"
                                class="mt-1 block w-full text-sm text-slate-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-full file:border-0
                                       file:text-xs file:font-bold
                                       file:bg-red-50 file:text-red-600
                                       hover:file:bg-red-100 cursor-pointer">
                        </div>

                        <div>
                            <select name="nama_bank" required
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                                <option value="">Pilih Bank</option>
                                <option value="BCA">BCA</option>
                                <option value="MANDIRI">MANDIRI</option>
                                <option value="BRI">BRI</option>
                                <option value="BNI">BNI</option>
                            </select>
                        </div>

                        <div>
                            <input type="number" name="nomor_rekening" placeholder="No Rekening"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition-all">
                            Simpan
                        </button>
                        <button type="button" id="btnBatalKurir"
                            class="px-6 py-3 border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT KURIR --}}
    <div id="modalEditKurir" class="fixed inset-0 z-[9999] hidden" style="background: rgba(0,0,0,0.5);">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-[2rem] shadow-xl w-full max-w-lg relative">

                <form id="formEditKurir" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <h3 class="text-2xl font-black text-[#5B000B] mb-6">Edit Data Kurir</h3>

                    <div class="space-y-4">
                        <div>
                            <input type="text" name="name" id="edit_name" placeholder="Nama"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <input type="email" name="email" id="edit_email" placeholder="Email"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <input type="password" name="password"
                                placeholder="Password baru (kosongkan jika tidak diubah)"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                minlength="8">
                        </div>

                        <div>
                            <input type="text" name="no_telp" id="edit_no_telp" placeholder="No HP"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 font-bold uppercase tracking-widest ml-1">Foto
                                Profil</label>
                            <input type="file" name="foto" accept="image/*"
                                class="mt-1 block w-full text-sm text-slate-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-full file:border-0
                                       file:text-xs file:font-bold
                                       file:bg-red-50 file:text-red-600
                                       hover:file:bg-red-100 cursor-pointer">
                        </div>

                        <div>
                            <select name="nama_bank" id="edit_nama_bank" required
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500">
                                <option value="">Pilih Bank</option>
                                <option value="BCA">BCA</option>
                                <option value="MANDIRI">MANDIRI</option>
                                <option value="BRI">BRI</option>
                                <option value="BNI">BNI</option>
                            </select>
                        </div>

                        <div>
                            <input type="number" name="nomor_rekening" id="edit_nomor_rekening"
                                placeholder="No Rekening"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-red-500 focus:border-red-500"
                                required>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition-all">
                            Simpan Perubahan
                        </button>
                        <button type="button" id="btnBatalEdit"
                            class="px-6 py-3 border border-gray-200 rounded-xl font-bold text-gray-600 hover:bg-gray-50 transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // === Modal Tambah ===
        const modal = document.getElementById('modalTambahKurir');
        const btnBuka = document.getElementById('btnTambahKurir');
        const btnTutup = document.getElementById('btnBatalKurir');

        btnBuka.addEventListener('click', () => modal.classList.remove('hidden'));
        btnTutup.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.classList.add('hidden');
        });

        // === Modal Edit ===
        const modalEdit = document.getElementById('modalEditKurir');
        const btnBatalEdit = document.getElementById('btnBatalEdit');

        function bukaModalEdit(id, name, email, no_telp, nama_bank, nomor_rekening) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_no_telp').value = no_telp;
            document.getElementById('edit_nama_bank').value = nama_bank;
            document.getElementById('edit_nomor_rekening').value = nomor_rekening;

            const baseUrl = "{{ url('superadmin/kelola-kurir/update') }}";
            document.getElementById('formEditKurir').action = baseUrl + '/' + id;

            modalEdit.classList.remove('hidden');
        }

        btnBatalEdit.addEventListener('click', () => modalEdit.classList.add('hidden'));
        modalEdit.addEventListener('click', function(e) {
            if (e.target === modalEdit) modalEdit.classList.add('hidden');
        });
    </script>
</x-app-layout>
