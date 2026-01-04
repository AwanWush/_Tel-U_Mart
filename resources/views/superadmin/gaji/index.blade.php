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

        .text-tj-red {
            color: #dc2626;
        }

        .rounded-tj {
            border-radius: 1.5rem;
        }
    </style>

    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-7 lg:px-8">

            {{-- BREADCRUMB --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center pt-[70px] gap-4">
                <nav class="flex items-center space-x-1 mb-4 text-sm font-bold text-gray-400">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-[#dc2626] transition-colors"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                        </svg>
                        <span class="tracking-wide">Dashboard</span>
                    </a>
                </nav>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 px-0">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Manajemen Upah</h2>
                    <p class="text-sm text-gray-500 font-medium">Informasi rincian gaji dan data perbankan personel
                        Mart.</p>
                </div>
                <button onclick="openModal('addPersonelModal')"
                    class="mt-4 md:mt-0 bg-[#5b000b] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md active:scale-95 transition-all duration-200 flex items-center justify-center border-none">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Personel & Gaji Baru
                </button>
            </div>

            {{-- SECTION FILTER BULAN & TAHUN --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-wrap items-end gap-4">
                <form action="{{ route('gaji.admin') }}" method="GET" class="flex flex-wrap items-end gap-4 w-full">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Pilih
                            Bulan</label>
                        <select name="bulan"
                            class="w-full border-gray-200 rounded-xl focus:ring-red-500 text-sm font-semibold">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}"
                                    {{ (int) request('bulan', date('n')) === $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Pilih
                            Tahun</label>
                        <select name="tahun"
                            class="w-full border-gray-200 rounded-xl focus:ring-red-500 text-sm font-semibold">
                            @foreach (range(date('Y'), date('Y') - 5) as $y)
                                <option value="{{ $y }}"
                                    {{ (int) request('tahun', date('Y')) === $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="bg-gray-800 hover:bg-black text-white px-6 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95 shadow-sm">
                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                    </button>
                    @if (request('bulan') || request('tahun'))
                        <a href="{{ route('gaji.admin') }}"
                            class="text-xs font-bold text-red-600 hover:underline mb-3">Reset</a>
                    @endif
                </form>
            </div>

            {{-- TABLE DATA --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-tj border border-red-100">
                <div
                    class="p-5 bg-dark-maroon text-white font-black flex justify-between items-center uppercase tracking-widest text-sm">
                    <span>Daftar Distribusi Gaji Mart</span>
                    {{-- Baris 74 yang sudah diperbaiki --}}
                    <span class="text-xs font-normal normal-case italic opacity-80">
                        Menampilkan:
                        {{ \Carbon\Carbon::create()->month((int) request('bulan', date('n')))->translatedFormat('F') }}
                        {{ request('tahun', date('Y')) }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="bg-red-50 text-red-700 uppercase text-[11px] font-black tracking-wider border-b border-red-100">
                            <tr>
                                <th class="px-6 py-4">Personel & Lokasi</th>
                                <th class="px-6 py-4">Info Rekening</th>
                                <th class="px-6 py-4">Nominal Gaji</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($adminGaji as $admin)
                                <tr class="hover:bg-red-50/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 leading-none">
                                            {{ $admin->nama_user ?? $admin->nama_custom }}
                                        </div>
                                        <div class="text-[10px] text-red-600 font-black mt-1 uppercase">
                                            📍 {{ $admin->nama_mart ?? 'Mart Belum Ditentukan' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[11px] font-black text-gray-800 uppercase">
                                            {{ $admin->nama_bank ?? '-' }}</div>
                                        <div class="text-xs font-mono text-gray-500">
                                            {{ $admin->nomor_rekening ?? 'Belum Diisi' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-green-600 font-black text-sm">Rp
                                            {{ number_format($admin->gaji, 0, ',', '.') }}</div>
                                        <div class="text-[9px] text-gray-400 font-medium">ID: #00{{ $admin->id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button onclick="showDetail({{ json_encode($admin) }})"
                                            class="bg-blue-600 text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase hover:bg-blue-700 active:scale-95 transition-all border-none shadow-sm">
                                            Detail Data
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-medium italic">
                                        Belum ada data gaji untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

        function showDetail(admin) {
            document.getElementById('det_nama').innerText = admin.nama_user || admin.nama_custom;
            document.getElementById('det_jabatan').innerText = admin.jabatan || 'Staf';
            document.getElementById('det_mart').innerText = admin.nama_mart || 'Luar Sistem';
            document.getElementById('det_bank').innerText = admin.nama_bank || '-';
            document.getElementById('det_rek').innerText = admin.nomor_rekening || '-';
            document.getElementById('det_gaji').innerText = 'Rp ' + admin.gaji.toLocaleString('id-ID');
            document.getElementById('det_waktu').innerText = admin.tanggal_gaji ? admin.tanggal_gaji : 'Belum tercatat';

            openModal('detailModal');
        }
    </script>
</x-app-layout>
