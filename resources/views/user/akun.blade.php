<x-app-layout>
    {{-- Header Section --}}
    <div class="bg-white border-b border-gray-200 mt-[120px]"> {{-- Sesuaikan mt dengan tinggi navbar Anda --}}
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-20 lg:px-8">
            <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-tight">
                Akun Saya
            </h2>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-6 items-start">

            {{-- SIDEBAR (FIXED/STICKY) --}}
            {{-- h-fit memastikan sidebar hanya setinggi isinya, sticky membuatnya tetap di atas saat scroll --}}
            <div class="w-full md:w-64 flex-shrink-0 sticky top-24">
                <div class="bg-white shadow sm:rounded-2xl overflow-hidden border border-gray-100">
                    <div class="p-6 flex flex-col items-center bg-white">
                        {{-- FOTO PROFIL --}}
                        @php
                            $imagePath =
                                $user->gambar && file_exists(public_path('storage/' . $user->gambar))
                                    ? asset('storage/' . $user->gambar)
                                    : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                        @endphp

                        <img src="{{ $imagePath }}" alt="Foto Profil"
                            class="w-24 h-24 object-cover rounded-full border-4 border-gray-50 shadow-md mb-4">

                        <h3 class="text-base font-black text-slate-800 tracking-tight text-center">{{ $user->name }}
                        </h3>
                        <p class="text-xs text-slate-500 mb-6 text-center break-all">{{ $user->email }}</p>

                        {{-- NAVIGASI --}}
                        <div class="flex flex-col w-full space-y-2">
                            {{-- Riwayat Pesanan - Sekarang menggunakan style yang sama dengan Profil Saya --}}
                            <button data-tab="pesanan"
                                class="tab-btn bg-white text-slate-600 border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all flex items-center gap-3">
                                <i class="fas fa-shopping-bag w-4"></i> Riwayat Pesanan
                            </button>

                            {{-- Metode Pembayaran --}}
                            <button data-tab="pembayaran"
                                class="tab-btn bg-white text-slate-600 border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all flex items-center gap-3">
                                <i class="fas fa-credit-card w-4"></i> Metode Pembayaran
                            </button>

                            {{-- Profil Saya --}}
                            <button data-tab="profil"
                                class="tab-btn bg-white text-slate-600 border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all flex items-center gap-3">
                                <i class="fas fa-user w-4"></i> Profil Saya
                            </button>

                            {{-- Tombol Keluar tetap Merah sesuai referensi --}}
                            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-700 transition-all w-full shadow-lg shadow-red-200">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KONTEN KANAN (SCROLLABLE) --}}
            <div class="w-full md:w-3/4">
                <div class="bg-white shadow sm:rounded-lg p-6">

                    {{-- TAB PESANAN --}}
                    <div class="flex-1 w-full">
                        <div class="bg-white shadow sm:rounded-2xl border border-gray-100 p-6">
                            {{-- Isi Tab Pesanan/Profil tetap di sini --}}
                            <div id="tab-pesanan" class="tab-content">
                                <h3 class="text-lg font-black text-slate-800 mb-4 flex items-center gap-2">
                                    <span class="w-1 h-6 bg-red-600 rounded-full"></span> Riwayat Pesanan Saya
                                </h3>
                                {{-- Wrapper overflow-x agar tabel tidak merusak layout di mobile --}}
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm text-gray-700 border">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-2 border">No Order</th>
                                                <th class="px-4 py-2 border">Tanggal Order</th>
                                                <th class="px-4 py-2 border">Total Harga</th>
                                                <th class="px-4 py-2 border">Status</th>
                                                <th class="px-4 py-2 border text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($riwayat as $item)
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-2 border font-mono">{{ $item->id_transaksi }}
                                                    </td>
                                                    <td class="px-4 py-2 border">
                                                        {{ $item->created_at->format('d/m/Y H:i') }}</td>
                                                    <td class="px-4 py-2 border font-semibold">
                                                        Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-2 border">
                                                        <span
                                                            class="px-2 py-1 rounded text-xs font-bold {{ $item->status == 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                            {{ $item->status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 border text-center">
                                                        <button
                                                            onclick="showDetailOrder({
                                                    no_order: '{{ $item->id_transaksi }}',
                                                    tanggal: '{{ $item->created_at->format('d/m/Y, H.i') }}',
                                                    total: {{ $item->total_harga }},
                                                    tipe: '{{ $item->tipe_layanan ?? 'delivery' }}',
                                                    alamat_tujuan: '{{ $item->metode_pembayaran }}', 
                                                    items: [
                                                        @foreach ($item->details as $detail)
                                                        {
                                                            nama_produk: '{{ $detail->nama_produk }}',
                                                            nama_mart: 'T-Mart Point', 
                                                            qty: {{ $detail->jumlah }}, 
                                                            harga_satuan: {{ $detail->harga_satuan }}
                                                        }@if (!$loop->last),@endif @endforeach
                                                    ]
                                                })"
                                                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition">
                                                            Lihat Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">Belum ada riwayat
                                                        pembelian.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Modal Detail Pesanan --}}
                            <div id="detailModal"
                                class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] overflow-y-auto px-4 py-10">
                                <div class="flex min-h-full items-start justify-center pt-20 pb-10">
                                    <div
                                        class="bg-white rounded-2xl shadow-2xl w-full max-w-md flex flex-col relative animate-in fade-in zoom-in duration-200 max-h-[80vh] overflow-y-auto">
                                        <div
                                            class="p-5 border-b flex justify-between items-center bg-gray-50/80 sticky top-0 z-10 backdrop-blur-md">
                                            <h4 class="text-lg font-bold text-slate-800">Detail Pesanan</h4>
                                            <button onclick="closeDetail()"
                                                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-times text-gray-500"></i>
                                            </button>
                                        </div>

                                        <div class="p-6 flex-1 bg-white">
                                            <div id="detailContent" class="text-sm text-gray-700"></div>
                                        </div>

                                        <div class="p-5 border-t bg-gray-50/50 sticky bottom-0 z-10 backdrop-blur-md">
                                            <button onclick="closeDetail()"
                                                class="w-full bg-slate-900 text-white py-3.5 rounded-xl font-bold hover:bg-black transition-all shadow-lg active:scale-[0.98]">
                                                Tutup Rincian
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{-- TAB PROFIL --}}
<div id="tab-profil" class="tab-content hidden">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header Tab --}}
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Profil Saya</h3>
                <p class="text-xs text-slate-500">Kelola informasi pribadi dan pengaturan keamanan akun Anda</p>
            </div>
            {{-- Tombol Edit menggunakan warna Utama #dc2626 --}}
            <button id="editProfilBtn" 
                class="bg-[#dc2626] hover:bg-[#b91c1c] text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
                <i class="fas fa-user-edit"></i> Edit Profil
            </button>
        </div>

        <div class="p-6">
            {{-- VIEW PROFIL --}}
            <div id="profil-view" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat Email</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->email }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor HP</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->no_telp ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Registrasi</p>
                        <p class="text-sm font-bold text-slate-700">{{ $user->created_at->format('d-m-Y') }}</p>
                    </div>

                    @if ($user->penghuni_asrama === 'ya')
                        <div class="md:col-span-2 p-4 bg-[#fee2e2] rounded-2xl border border-[#fecaca] grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-[#b91c1c] uppercase tracking-widest">Gedung</p>
                                <p class="text-sm font-bold text-[#5B000B]">{{ $user->lokasi->nama_lokasi ?? ($user->alamat_gedung ?? '-') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black text-[#b91c1c] uppercase tracking-widest">Nomor Kamar</p>
                                <p class="text-sm font-bold text-[#5B000B]">{{ $user->nomor_kamar ?? '-' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- FORM EDIT PROFIL --}}
            <div id="profil-form" class="hidden">
                <form action="{{ route('user.akun.update', ['tab' => 'profil']) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama</label>
                            <input type="text" name="name" value="{{ $user->name }}"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] text-sm font-bold">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] text-sm font-bold">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nomor HP</label>
                            <input type="text" name="no_telp" value="{{ $user->no_telp }}"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] text-sm font-bold">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Apakah Penghuni Asrama?</label>
                            <select name="penghuni_asrama" id="penghuni_asrama"
                                class="w-full border-gray-200 rounded-xl focus:ring-[#dc2626] focus:border-[#dc2626] text-sm font-bold">
                                <option value="tidak" {{ $user->penghuni_asrama === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                <option value="ya" {{ $user->penghuni_asrama === 'ya' ? 'selected' : '' }}>Ya</option>
                            </select>
                        </div>
                    </div>

                    {{-- ALAMAT GEDUNG --}}
                    <div id="alamatGedungField" style="display: {{ $user->penghuni_asrama === 'ya' ? 'block' : 'none' }}" class="space-y-4 p-5 bg-gray-50 rounded-2xl border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-[#b91c1c] uppercase tracking-widest ml-1">Alamat Gedung</label>
                                <select name="lokasi_id" class="w-full border-gray-200 rounded-xl text-sm font-bold focus:ring-[#E68757]">
                                    <option value="">-- Pilih Gedung --</option>
                                    @foreach ($gedungs as $gedung)
                                        <option value="{{ $gedung->id }}" {{ $user->lokasi_id == $gedung->id ? 'selected' : '' }}>
                                            {{ $gedung->nama_lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-[#b91c1c] uppercase tracking-widest ml-1">Nomor Kamar</label>
                                <select name="nomor_kamar" class="w-full border-gray-200 rounded-xl text-sm font-bold focus:ring-[#E68757]">
                                    <option value="">-- Pilih Nomor Kamar --</option>
                                    @php
                                        $listKamar = \App\Models\MasterKamar::orderBy('nomor_kamar', 'asc')->get();
                                    @endphp
                                    @foreach ($listKamar as $kamar)
                                        <option value="{{ $kamar->nomor_kamar }}" {{ $user->nomor_kamar == $kamar->nomor_kamar ? 'selected' : '' }}>
                                            {{ $kamar->nomor_kamar }} (Lantai {{ $kamar->lantai }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Password Baru (Opsional)</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diganti"
                                    class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#DB4B3A]">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                                    class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#DB4B3A]">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Foto Profil</label>
                        <input type="file" name="gambar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#fee2e2] file:text-[#dc2626] hover:file:bg-[#fecaca] cursor-pointer">
                    </div>

                    <div class="flex gap-3 pt-4">
                        {{-- Tombol Simpan menggunakan Warna Utama #dc2626 --}}
                        <button type="submit"
                            class="flex-1 bg-[#dc2626] hover:bg-[#b91c1c] text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-100">
                            Simpan Perubahan
                        </button>
                        {{-- Tombol Batal menggunakan Gradasi Putih/Hitam (Grayscale) --}}
                        <button type="button" id="batalEditBtn"
                            class="flex-1 bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                            {{-- TAB METODE PEMBAYARAN --}}
                            <div id="tab-pembayaran" class="tab-content hidden">
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                    {{-- Header Tab --}}
                                    <div
                                        class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                                        <div>
                                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">
                                                Dompet & Pembayaran</h3>
                                            <p class="text-xs text-slate-500">Kelola rincian pembayaran untuk transaksi
                                                Anda</p>
                                        </div>
                                        {{-- Tombol ini yang tetap dipertahankan (Warna Oriental Red) --}}
                                        <button id="addPaymentBtn"
                                            class="bg-[#DB4B3A] hover:bg-[#930014] text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>

                                    <div class="p-6">
                                        @if ($pembayaran->isEmpty())
                                            <div class="py-12 text-center">
                                                <div
                                                    class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                                    <i class="fas fa-credit-card text-gray-400 text-2xl"></i>
                                                </div>
                                                <p class="text-gray-500 font-bold text-sm">Belum ada metode pembayaran
                                                    yang disimpan.</p>
                                            </div>
                                        @else
                                            <div class="grid grid-cols-1 gap-4">
                                                @foreach ($pembayaran as $pay)
                                                    @php
                                                        $showPay = true;
                                                        if ($pay->kategori === 'COD') {
                                                            $showPay = true;
                                                        }
                                                    @endphp

                                                    @if ($showPay)
                                                        <div
                                                            class="group flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:border-[#DB4B3A]/30 hover:bg-gray-50 transition-all duration-300">
                                                            <div class="flex items-center gap-4">
                                                                {{-- Icon Berdasarkan Kategori --}}
                                                                <div
                                                                    class="w-12 h-12 rounded-xl bg-[#5B000B]/5 flex items-center justify-center text-[#930014]">
                                                                    @if ($pay->kategori == 'E-Wallet')
                                                                        <i class="fas fa-mobile-alt text-xl"></i>
                                                                    @elseif($pay->kategori == 'Virtual Account')
                                                                        <i class="fas fa-university text-xl"></i>
                                                                    @elseif($pay->kategori == 'COD')
                                                                        <i class="fas fa-hand-holding-usd text-xl"></i>
                                                                    @else
                                                                        <i class="fas fa-wallet text-xl"></i>
                                                                    @endif
                                                                </div>

                                                                <div>
                                                                    <div class="flex items-center gap-2">
                                                                        <span
                                                                            class="font-black text-slate-800 uppercase text-sm tracking-tight">{{ $pay->kategori }}</span>
                                                                        @if ($pay->bank)
                                                                            <span
                                                                                class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[9px] font-black rounded uppercase">{{ $pay->bank }}</span>
                                                                        @endif
                                                                    </div>

                                                                    <div class="mt-1 space-y-0.5">
                                                                        {{-- @if ($pay->keterangan)
                                                                            <p
                                                                                class="text-xs text-slate-600 font-bold">
                                                                                {{ $pay->keterangan }}</p>
                                                                        @endif --}}
                                                                        @if ($pay->telepon)
                                                                            <p
                                                                                class="text-xs text-slate-500 font-mono">
                                                                                ID: {{ $pay->telepon }}</p>
                                                                        @endif
                                                                        @if ($pay->norek)
                                                                            <p
                                                                                class="text-xs text-slate-500 font-mono tracking-wider">
                                                                                No: {{ $pay->norek }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Aksi Hapus --}}
                                                            <form method="POST"
                                                                action="{{ route('pembayaran.destroy', $pay->id) }}"
                                                                onsubmit="return confirm('Hapus metode ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="opacity-0 group-hover:opacity-100 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:text-white hover:bg-red-600 transition-all duration-200">
                                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="tab-transaksi" class="tab-content hidden">
                                <div class="border border-gray-200 rounded-lg p-5 bg-white">
                                    <h3 class="text-lg font-semibold mb-4">Transaksi Saya</h3>

                                    {{-- Tabel transaksi dari kode kamu --}}
                                    <x-transaksi-table :transaksi="$transaksi" :filter="$statusFilter ?? null" />

                                    {{-- Tombol Bayar Midtrans --}}
                                    @foreach ($transaksi as $item)
                                        @if ($item->status == 'Menunggu Pembayaran')
                                            <button class="px-3 py-2 bg-indigo-600 text-white rounded mt-2 pay-button"
                                                data-id="{{ $item->id }}"
                                                data-amount="{{ $item->total_harga }}">
                                                Bayar Sekarang
                                            </button>
                                        @endif
                                    @endforeach

                                </div>
                            </div>



                            {{-- Modal Tambah Metode Pembayaran --}}
                            <div id="paymentModal"
                                class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                                <div class="bg-white rounded-lg shadow-lg w-96 p-5">
                                    <h4 class="text-lg font-semibold mb-3">Tambah Metode Pembayaran</h4>

                                    <form action="{{ route('pembayaran.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                            <select name="kategori" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="E-Wallet">E-Wallet</option>
                                                <option value="QRIS">QRIS</option>
                                                <option value="Virtual Account">Virtual Account</option>
                                                <option value="COD">COD (Cash on Delivery)</option>
                                            </select>
                                        </div>

                                        {{-- KETERANGAN NORMAL (E-Wallet) --}}
                                        <div id="keteranganField" class="mb-3">
                                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                                            <input type="text" name="keterangan" id="keteranganInput"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                placeholder="Contoh: OVO, GoPay, Dana">
                                        </div>

                                        {{-- NOMOR TELEPON UNTUK E-WALLET --}}
                                        <div id="teleponField" class="mb-3 hidden">
                                            <label class="block text-sm font-medium text-gray-700">Nomor
                                                Telepon</label>
                                            <input type="text" name="telepon"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                placeholder="08xxxxxxxxxx">
                                        </div>

                                        {{-- PILIH BANK UNTUK VIRTUAL ACCOUNT --}}
                                        <div id="bankField" class="mb-3 hidden">
                                            <label class="block text-sm font-medium text-gray-700">Bank</label>
                                            <select name="bank"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="BCA">BCA</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="BRI">BRI</option>
                                                <option value="BNI">BNI</option>
                                            </select>

                                            <label class="block text-sm font-medium text-gray-700 mt-3">Nomor
                                                Rekening</label>
                                            <input type="text" name="norek"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                placeholder="Masukkan nomor rekening">
                                        </div>

                                        <div class="flex justify-end space-x-2">
                                            <button type="button" id="cancelPaymentBtn"
                                                class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-500 transition">Batal</button>
                                            <button type="submit"
                                                class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-500 transition">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SCRIPT --}}
                    <script>
                        // ================= TAB =================
                        const buttons = document.querySelectorAll('.tab-btn');
                        const contents = document.querySelectorAll('.tab-content');

                        function showTab(name) {
                            contents.forEach(c => c.classList.add('hidden'));
                            document.getElementById('tab-' + name).classList.remove('hidden');
                        }

                        buttons.forEach(b => {
                            b.addEventListener('click', () => showTab(b.dataset.tab));
                        });

                        showTab("{{ $activeTab }}"); // default tab


                        // ================= TOGGLE GEDUNG =================
                        const asramaSelect = document.getElementById('penghuni_asrama');
                        const alamatField = document.getElementById('alamatGedungField');
                        const alamatSelect = alamatField ? alamatField.querySelector('select[name="alamat_gedung"]') : null;

                        function toggleGedung() {
                            if (!asramaSelect || !alamatField) return;

                            if (asramaSelect.value === 'ya') {
                                alamatField.style.display = 'block';
                            } else {
                                alamatField.style.display = 'none';
                                // if (alamatSelect) alamatSelect.value = '';
                                alamatField.querySelectorAll('select').forEach(select => select.value = '');
                            }
                        }

                        if (asramaSelect) {
                            asramaSelect.addEventListener('change', toggleGedung);
                            toggleGedung(); // panggil saat halaman load
                        }

                        // ================= EDIT PROFIL =================
                        const editBtn = document.getElementById('editProfilBtn');
                        const cancelBtn = document.getElementById('batalEditBtn');
                        const profilView = document.getElementById('profil-view');
                        const profilForm = document.getElementById('profil-form');

                        if (editBtn) {
                            editBtn.addEventListener('click', () => {
                                profilView.classList.add('hidden');
                                profilForm.classList.remove('hidden');
                            });
                        }

                        if (cancelBtn) {
                            cancelBtn.addEventListener('click', () => {
                                profilForm.classList.add('hidden');
                                profilView.classList.remove('hidden');
                            });
                        }

                        // ================= MODAL PEMBAYARAN =================
                        const addPaymentBtn = document.getElementById('addPaymentBtn');
                        const paymentModal = document.getElementById('paymentModal');
                        const cancelPaymentBtn = document.getElementById('cancelPaymentBtn');

                        if (addPaymentBtn) {
                            addPaymentBtn.addEventListener('click', () => {
                                paymentModal.classList.remove('hidden');
                            });
                        }

                        if (cancelPaymentBtn) {
                            cancelPaymentBtn.addEventListener('click', () => {
                                paymentModal.classList.add('hidden');
                            });
                        }

                        // ================= DETAIL PESANAN =================
                        // ================= DETAIL PESANAN (VERSI FIX) =================
                        function showDetailOrder(data) {
                            const modal = document.getElementById('detailModal');
                            const content = document.getElementById('detailContent');

                            // 1. Bangun rincian produk
                            let itemsHtml = '';
                            if (data.items && data.items.length > 0) {
                                data.items.forEach(item => {
                                    let totalPerItem = item.qty * item.harga_satuan;
                                    itemsHtml += `
                <div class="py-3 border-b border-gray-100 last:border-0">
                    <div class="flex justify-between items-start">
                        <div class="pr-3">
                            <p class="font-bold text-slate-800 leading-tight">${item.nama_produk}</p>
                            <p class="text-[10px] text-indigo-600 font-bold uppercase italic mt-1">Mart: ${item.nama_mart}</p>
                            <p class="text-xs text-gray-500 mt-1">${item.qty} x Rp ${item.harga_satuan.toLocaleString('id-ID')}</p>
                        </div>
                        <p class="font-bold text-slate-900 whitespace-nowrap">Rp ${totalPerItem.toLocaleString('id-ID')}</p>
                    </div>
                </div>`;
                                });
                            } else {
                                itemsHtml = '<p class="text-xs text-gray-400 italic py-4 text-center">Rincian belanja tidak ditemukan.</p>';
                            }

                            // 2. Logika Lokasi (Hanya satu isDelivery agar tidak error)
                            const isDelivery = data.tipe.toLowerCase() === 'delivery';
                            // PERBAIKAN: Ganti data.gedung menjadi data.alamat_tujuan
                            const lokasiTujuan = isDelivery ?
                                `<div class="flex items-center gap-2 font-bold text-slate-700">
        <i class="fas fa-map-marker-alt text-red-500"></i> ${data.alamat_tujuan}
       </div>` :
                                `Ambil di Toko`;

                            // 3. Render HTML
                            content.innerHTML = `
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-4 bg-slate-100 px-5 py-4 rounded-xl border border-slate-200">
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">No Order</p>
                    <p class="font-mono font-bold text-slate-900 break-all">${data.no_order}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Metode</p>
                    <span class="inline-block px-2 py-0.5 rounded bg-indigo-600 text-white text-[10px] font-black italic uppercase">${data.tipe}</span>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button onclick="toggleProductList()" class="w-full p-4 flex justify-between items-center bg-white hover:bg-gray-50 transition-colors">
                    <span class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-receipt text-indigo-500"></i> Rincian Belanja
                    </span>
                    <span id="toggleIcon" class="text-xs text-gray-400"><i class="fas fa-chevron-down transition-transform duration-300"></i></span>
                </button>
                <div id="productList"
     class="px-4 bg-white border-t divide-y divide-gray-50 max-h-0 overflow-hidden transition-all duration-300">
                    ${itemsHtml}
                </div>
            </div>

            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 shadow-inner">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2">Tujuan / Lokasi</p>
                ${lokasiTujuan}
            </div>

            <div class="flex justify-between items-center px-2 py-1 border-t-2 border-dashed border-gray-100 pt-4">
                <span class="font-black text-slate-400 uppercase text-[10px] tracking-[0.2em]">Total Tagihan</span>
                <span class="text-2xl font-black text-red-600 tracking-tighter">Rp ${data.total.toLocaleString('id-ID')}</span>
            </div>
        </div>
    `;

                            modal.classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }

                        // Fungsi bantu untuk buka/tutup rincian produk
                        function toggleProductList() {
                            const list = document.getElementById('productList');
                            const icon = document.querySelector('#toggleIcon i');

                            if (list.style.maxHeight && list.style.maxHeight !== '0px') {
                                list.style.maxHeight = '0px';
                                icon.style.transform = 'rotate(0deg)';
                            } else {
                                list.style.maxHeight = list.scrollHeight + 'px';
                                icon.style.transform = 'rotate(180deg)';
                            }
                        }


                        function closeDetail() {
                            document.getElementById('detailModal').classList.add('hidden');
                            document.body.style.overflow = ''; // ⬅️ INI YANG HILANG
                        }


                        function ajukanKomplain(id) {
                            alert('Fitur komplain untuk pesanan #' + id + ' akan ditambahkan.');
                        }

                        function beliKembali(id) {
                            alert('Menambahkan pesanan #' + id + ' ke keranjang ulang.');
                        }

                        // ================= LOGIC KATEGORI PEMBAYARAN =================
                        const kategoriSelect = document.querySelector('select[name="kategori"]');
                        const ketField = document.getElementById('keteranganField');
                        const teleponField = document.getElementById('teleponField');
                        const bankField = document.getElementById('bankField');

                        function updateKategoriFields() {
                            if (!kategoriSelect) return;

                            const v = kategoriSelect.value;

                            // reset semua ke hidden
                            ketField.classList.add('hidden');
                            teleponField.classList.add('hidden');
                            bankField.classList.add('hidden');

                            // E-Wallet
                            if (v === 'E-Wallet') {
                                ketField.classList.remove('hidden');
                                teleponField.classList.remove('hidden');
                            }

                            // QRIS → tetap hidden semua
                            if (v === 'QRIS') {}

                            // Virtual Account
                            if (v === 'Virtual Account') {
                                bankField.classList.remove('hidden');
                            }

                            // COD → tetap hidden semua
                            if (v === 'COD') {}
                        }

                        if (kategoriSelect) {
                            kategoriSelect.addEventListener('change', updateKategoriFields);
                            updateKategoriFields(); // trigger default
                        }
                    </script>

                    <script>
                        document.querySelectorAll('.pay-button').forEach(btn => {
                            btn.addEventListener('click', function() {
                                fetch("{{ route('payment.create') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            amount: this.dataset.amount,
                                            transaction_id: this.dataset.id
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => snap.pay(data.snap_token));
                            });
                        });
                    </script>

</x-app-layout>
