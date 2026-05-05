{{-- resources/views/superadmin/absensi/index.blade.php --}}
<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-[60px] space-y-8">

            {{-- HEADER --}}
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-[#5B000B] uppercase tracking-tighter">Sistem Absensi Kurir</h2>
                    <p class="text-gray-500 font-medium">Monitoring kehadiran harian dan konfigurasi QR Code.</p>
                </div>
                <div class="p-4 bg-indigo-50 rounded-2xl">
                    <i class="fas fa-fingerprint text-3xl text-indigo-600"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- QR CODE CONFIGURATION --}}
                <div class="lg:col-span-1 space-y-6">
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
                        <div class="p-6 bg-dark-maroon flex justify-between items-center">
                            <h3 class="text-white font-black uppercase tracking-widest text-sm">Log Kehadiran Hari Ini</h3>
                            <span class="bg-white/10 text-accent px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                {{ date('d M Y') }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kurir</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Jam Absen</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Peta</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($absensis as $absen)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center font-bold text-red-600 text-xs">
                                                        {{ substr($absen->user->name, 0, 1) }}
                                                    </div>
                                                    <span class="font-bold text-gray-800 text-sm">{{ $absen->user->name }}</span>
                                                </div>
                                            </td>
                                            {{-- KOLOM JAM REAL-TIME (WIB) --}}
                                            <td class="p-5 text-center font-mono text-sm text-gray-600 font-bold">
                                                {{ \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') }} WIB
                                            </td>
                                            <td class="p-5 text-center">
                                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase {{ $absen->status == 'Tepat Waktu' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $absen->status }}
                                                </span>
                                            </td>
                                            <td class="p-5 text-center">
                                                <a href="https://www.google.com/maps?q={{ $absen->koordinat_absen }}"
                                                    target="_blank"
                                                    class="text-blue-500 hover:text-blue-700 transition">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-10 text-center text-gray-400 italic text-sm">
                                                Belum ada kurir yang absen hari ini.</td>
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