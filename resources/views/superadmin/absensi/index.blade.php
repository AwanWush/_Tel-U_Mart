{{-- resources/views/superadmin/absensi/index.blade.php --}}
<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-[60px] space-y-8">

            {{-- BREADCRUMB / BACK TO DASHBOARD --}}
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('dashboard.superadmin') }}"
                   class="flex items-center gap-1.5 font-semibold text-[#5B000B] hover:underline transition">
                    <i class="fas fa-home text-xs"></i>
                    Dashboard
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-400 font-medium">Absensi Kurir</span>
            </div>

            {{-- HEADER --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-[#5B000B] uppercase tracking-tighter">Sistem Absensi Kurir</h2>
                    <p class="text-gray-500 font-medium">Monitoring kehadiran harian dan konfigurasi QR Code.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="p-4 bg-indigo-50 rounded-2xl">
                        <i class="fas fa-fingerprint text-3xl text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- QR CODE CONFIGURATION --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- SUMMARY CARD --}}
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 space-y-4">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Ringkasan Hari Ini</h3>
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-2xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-sm">Tepat Waktu</span>
                            </div>
                            <span class="font-black text-green-600 text-xl">
                                {{ $absensis->where('status', 'Tepat Waktu')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-2xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-clock text-red-500 text-xs"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-sm">Terlambat</span>
                            </div>
                            <span class="font-black text-red-500 text-xl">
                                {{ $absensis->where('status', 'Terlambat')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-gray-500 text-xs"></i>
                                </div>
                                <span class="font-bold text-gray-700 text-sm">Total Hadir</span>
                            </div>
                            <span class="font-black text-gray-700 text-xl">{{ $absensis->count() }}</span>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 text-center">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6">QR Code Aktif</h3>
                        <div class="bg-gray-50 p-6 rounded-3xl border-2 border-dashed border-gray-200 inline-block mb-6">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TJT-TELKOM-77"
                                alt="QR Absensi" class="w-48 h-48 mx-auto">
                        </div>
                        <button onclick="window.print()"
                            class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-gray-800 transition-all shadow-lg">
                            <i class="fas fa-print mr-2"></i> Cetak QR Code
                        </button>
                        <p class="text-[10px] text-gray-400 mt-4 leading-relaxed uppercase font-bold">
                            QR ini berlaku untuk semua driver di area Telkom University.
                        </p>
                    </div>

                    
                </div>

                {{-- ATTENDANCE LOG TABLE --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-[#5B000B] flex justify-between items-center">
                            <h3 class="text-white font-black uppercase tracking-widest text-sm">Log Kehadiran Hari Ini</h3>
                            <span class="bg-white/10 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                {{ date('d M Y') }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            Kurir</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                            Status Akun</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                            Jam Masuk</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                            Status Absen</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                            Peta</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($absensis as $absen)
                                        <tr class="hover:bg-gray-50 transition">
                                            {{-- KURIR NAME --}}
                                            <td class="p-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-full bg-[#5B000B]/10 flex items-center justify-center font-black text-[#5B000B] text-sm">
                                                        {{ substr($absen->user->name ?? '?', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <span class="font-bold text-gray-800 text-sm block">{{ $absen->user->name ?? '-' }}</span>
                                                        <span class="text-[10px] text-gray-400">{{ $absen->user->email ?? '' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- STATUS AKUN DRIVER --}}
                                            <td class="p-5 text-center">
                                                @php $statusAkun = $absen->user->status ?? 'nonaktif'; @endphp
                                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase
                                                    {{ $statusAkun === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                                    <i class="fas fa-circle text-[6px] mr-1"></i>
                                                    {{ ucfirst($statusAkun) }}
                                                </span>
                                            </td>
                                            {{-- JAM MASUK --}}
                                            <td class="p-5 text-center font-mono text-sm text-gray-700 font-bold">
                                                {{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB' : '-' }}
                                            </td>
                                            {{-- STATUS ABSEN --}}
                                            <td class="p-5 text-center">
                                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase
                                                    {{ ($absen->status ?? '') == 'Tepat Waktu' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $absen->status ?? 'Tidak Diketahui' }}
                                                </span>
                                            </td>
                                            {{-- PETA --}}
                                            <td class="p-5 text-center">
                                                @if($absen->koordinat_absen)
                                                    <a href="https://www.google.com/maps?q={{ $absen->koordinat_absen }}"
                                                        target="_blank"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 hover:text-blue-700 transition">
                                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                                    </a>
                                                @else
                                                    <span class="text-gray-300 text-xs">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="p-16 text-center">
                                                <div class="flex flex-col items-center gap-3 text-gray-300">
                                                    <i class="fas fa-clipboard-list text-5xl"></i>
                                                    <span class="text-sm font-semibold">Belum ada kurir yang absen hari ini.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>