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

            {{-- HEADER SECTION: Judul & Tombol Registrasi --}}
            <div class="flex flex-col md:flex-row justify-between items-start mb-3 gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">
                        Data Personel Admin
                    </h2>
                    <p class="text-sm text-slate-500 font-medium italic mt-1">
                        Manajemen akun admin dan penugasan unit operasional Mart.
                    </p>
                </div>

                {{-- Tombol Registrasi (Warna Merah Utama #dc2626) --}}
                <button onclick="openModal('addAdminModal')"
                    class="bg-[#5b000b] text-white py-2.5 px-6 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-[#b91c1c] transition-all shadow-lg shadow-red-200 flex items-center gap-2 active:scale-95">
                    <span class="text-lg">+</span> Registrasi Admin Mart
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-tj border border-red-100">
                <div
                    class="p-5 bg-dark-maroon text-white font-black flex justify-between items-center uppercase tracking-widest text-sm">
                    <span>Daftar Admin Mart Aktif</span>
                    <span class="text-xs font-normal normal-case opacity-70 italic">Total: {{ $admins->count() }}
                        Personel</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-red-50 text-red-700 uppercase text-[11px] font-black tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Nama Admin</th>
                                <th class="px-6 py-4">Penempatan</th>
                                <th class="px-6 py-4 text-center">Assign Unit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($admins as $admin)
                                <tr class="hover:bg-red-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 leading-none">{{ $admin->name }}</div>
                                        <div class="text-[10px] text-gray-400 mt-1 italic">{{ $admin->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-tighter w-fit">
                                                📍 {{ $admin->nama_mart ?? 'BELUM DITUGASKAN' }}
                                            </span>
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-bold uppercase w-fit {{ $admin->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $admin->status ?? 'Aktif' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('admin.update-mart', $admin->id) }}" method="POST"
                                                class="flex items-center space-x-2">
                                                @csrf
                                                <select name="mart_id"
                                                    class="border-red-100 rounded-xl text-[10px] font-bold py-1 focus:ring-red-500 pr-8">
                                                    <option value="">Pilih Mart...</option>
                                                    @foreach ($marts as $mart)
                                                        <option value="{{ $mart->id }}"
                                                            {{ $admin->mart_id == $mart->id ? 'selected' : '' }}>
                                                            {{ $mart->nama_mart }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit"
                                                    class="bg-red-600 text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase hover:bg-red-700 active:scale-95 transition-all border-none shadow-sm">
                                                    Update
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.toggle', $admin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase border transition-all active:scale-95 {{ $admin->status == 'aktif' ? 'border-red-600 text-red-600 hover:bg-red-50' : 'border-green-600 text-green-600 hover:bg-green-50' }}">
                                                    {{ $admin->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
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

    <div id="addAdminModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                onclick="closeModal('addAdminModal')"></div>

            <div
                class="inline-block bg-white rounded-tj text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border-t-8 border-dark-maroon z-50">
                <div class="bg-white px-6 py-8">
                    <h3 class="text-xl font-black text-gray-900 uppercase mb-6 border-b pb-2">Registrasi Admin Baru</h3>

                    <form action="{{ route('admin.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-black text-gray-700 uppercase mb-1 tracking-wider">Nama
                                Lengkap</label>
                            <input type="text" name="name" placeholder="Nama admin..."
                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 text-sm py-3 px-4" required>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black text-gray-700 uppercase mb-1 tracking-wider">Alamat
                                Email</label>
                            <input type="email" name="email" placeholder="email@tjt-mart.com"
                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 text-sm py-3 px-4" required>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black text-gray-700 uppercase mb-1 tracking-wider">Password
                                Sementara</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter..."
                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 text-sm py-3 px-4" required>
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black text-gray-700 uppercase mb-1 tracking-wider">Penempatan
                                Mart</label>
                            <select name="mart_id"
                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 text-sm py-3 px-4" required>
                                <option value="">Pilih Mart Cabang...</option>
                                @foreach ($marts as $mart)
                                    <option value="{{ $mart->id }}">{{ $mart->nama_mart }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 pt-6">
                            <button type="button" onclick="closeModal('addAdminModal')"
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all border-none uppercase text-xs">Batal</button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-red-600 text-white font-black uppercase text-xs rounded-xl hover:bg-red-700 shadow-lg active:scale-95 transition-all border-none">Daftarkan
                                Admin</button>
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
    </script>
</x-app-layout>
