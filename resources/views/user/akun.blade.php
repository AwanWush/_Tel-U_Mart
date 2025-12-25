<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Akun Saya
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        {{-- Pesan Alert --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- SIDEBAR --}}
                <div class="p-6 border-r flex flex-col items-center bg-gray-50">
                    {{-- FOTO PROFIL --}}
                    @php
                        $imagePath = $user->gambar && file_exists(public_path('storage/'.$user->gambar))
                            ? asset('storage/'.$user->gambar)
                            : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                    @endphp

                    <img src="{{ $imagePath }}"
                            alt="Foto Profil"
                            class="w-20 h-20 object-cover rounded-full border border-gray-300 shadow-sm mb-3">

                    <h3 class="text-sm font-semibold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-500 mb-4">{{ $user->email }}</p>

                    {{-- NAVIGASI --}}
                    <div class="flex flex-col w-full space-y-2">
                        <button data-tab="pesanan"
                                class="tab-btn bg-gray-800 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-700 transition active-tab">
                            Riwayat Pesanan Saya
                        </button>
                        
                        <button data-tab="pembayaran"
                                class="tab-btn bg-gray-800 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-700 transition">
                            Metode Pembayaran
                        </button>
                        
                        <button data-tab="profil"
                                class="tab-btn bg-gray-800 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-700 transition">
                            Profil
                        </button>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1.5 rounded text-sm hover:bg-red-500 transition w-full">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                

                {{-- KONTEN KANAN --}}
                <div class="md:col-span-3 p-6">
                    {{-- TAB PESANAN (RIWAYAT) --}}
                    <div id="tab-pesanan" class="tab-content">
                        <div class="border border-gray-200 rounded-lg p-5 bg-white">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Riwayat Pesanan Saya</h3>

                      <div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b">
                <th class="px-4 py-3">No Order</th>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
      <tbody class="divide-y divide-gray-100">
    @forelse($riwayat as $item)
        <tr class="text-sm">
            <td class="px-4 py-4 font-medium text-indigo-600">#{{ $item->id_transaksi }}</td>
            <td class="px-4 py-4 text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
            <td class="px-4 py-4 font-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            <td class="px-4 py-4">
                <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-600">
                    {{ $item->status }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-4 py-10 text-center text-gray-400 italic">
                Belum ada riwayat pesanan yang berhasil.
            </td>
        </tr>
    @endforelse
</tbody>
    </table>
</div>

                            {{-- Modal Detail Pesanan --}}
                            <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                                <div class="bg-white rounded-lg shadow-xl w-96 p-6">
                                    <h4 class="text-lg font-bold mb-4 border-b pb-2">Detail Transaksi</h4>
                                    <div id="detailContent" class="text-sm text-gray-700 space-y-3">
                                        {{-- Isi detail akan diisi via JS --}}
                                    </div>
                                    <div class="mt-6 flex justify-end">
                                        <button onclick="closeDetail()"
                                                class="bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-700 transition">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB PROFIL --}}
                    <div id="tab-profil" class="tab-content hidden">
                        <div class="border border-gray-200 rounded-lg p-5 bg-white">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Profil Saya</h3>

                            {{-- VIEW PROFIL --}}
                            <div id="profil-view" class="space-y-4">
                                <div class="flex border-b pb-2">
                                    <span class="w-32 text-gray-500 text-sm">Nama</span>
                                    <span class="font-medium text-sm">: {{ $user->name }}</span>
                                </div>
                                <div class="flex border-b pb-2">
                                    <span class="w-32 text-gray-500 text-sm">Email</span>
                                    <span class="font-medium text-sm">: {{ $user->email }}</span>
                                </div>
                                <div class="flex border-b pb-2">
                                    <span class="w-32 text-gray-500 text-sm">Nomor HP</span>
                                    <span class="font-medium text-sm">: {{ $user->no_telp ?? '-' }}</span>
                                </div>
                                @if($user->penghuni_asrama === 'ya')
                                    <div class="flex border-b pb-2">
                                        <span class="w-32 text-gray-500 text-sm">Gedung</span>
                                        <span class="font-medium text-sm">: {{ $user->lokasi->nama_lokasi ?? $user->alamat_gedung ?? '-' }}</span>
                                    </div>
                                    <div class="flex border-b pb-2">
                                        <span class="w-32 text-gray-500 text-sm">No. Kamar</span>
                                        <span class="font-medium text-sm">: {{ $user->nomor_kamar ?? '-' }}</span>
                                    </div>
                                @endif
                                <button id="editProfilBtn"
                                        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-500 transition shadow">
                                    Edit Profil
                                </button>
                            </div>

                            {{-- FORM EDIT PROFIL --}}
                            <div id="profil-form" class="hidden">
                                <form action="{{ route('user.akun.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="tab" value="profil">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">Nama</label>
                                            <input type="text" name="name" value="{{ $user->name }}" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700">Nomor HP</label>
                                        <input type="text" name="no_telp" value="{{ $user->no_telp}}" 
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                    </div>

                                    <div class="flex space-x-2 mt-6">
                                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-500 transition">
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" id="batalEditBtn" class="bg-gray-400 text-white px-4 py-2 rounded text-sm hover:bg-gray-500 transition">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- TAB METODE PEMBAYARAN --}}
                    <div id="tab-pembayaran" class="tab-content hidden">
                        <div class="border border-gray-200 rounded-lg p-5 bg-white">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Metode Pembayaran</h3>

                            {{-- List Metode Pembayaran --}}
                            <div class="space-y-3">
                                @forelse($pembayaran as $pay)
                                    <div class="flex justify-between items-center bg-gray-50 border rounded-lg p-4">
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $pay->kategori }}</div>
                                            <div class="text-xs text-gray-600 italic">
                                                {{ $pay->bank ?? '' }} {{ $pay->norek ?? '' }} {{ $pay->telepon ?? '' }}
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('pembayaran.destroy', $pay->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 text-xs font-semibold hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">Belum ada metode pembayaran.</p>
                                @endforelse
                            </div>

                            <button id="addPaymentBtn" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-500 transition shadow">
                                + Tambah Metode Pembayaran
                            </button>

                            {{-- Modal Tambah Metode Pembayaran --}}
                            <div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                                <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                                    <h4 class="text-lg font-bold mb-4">Tambah Metode</h4>
                                    <form action="{{ route('pembayaran.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-medium">Kategori</label>
                                            <select name="kategori" id="kategoriSelect" required class="w-full mt-1 border-gray-300 rounded text-sm">
                                                <option value="E-Wallet">E-Wallet (Dana/Ovo/Gopay)</option>
                                                <option value="Virtual Account">Bank Transfer (VA)</option>
                                                <option value="COD">COD</option>
                                            </select>
                                        </div>
                                        <div id="extraFields" class="space-y-3">
                                            {{-- Field Dinamis Muncul Disini via JS --}}
                                        </div>
                                        <div class="flex justify-end space-x-2 pt-4">
                                            <button type="button" id="cancelPaymentBtn" class="bg-gray-400 text-white px-4 py-2 rounded text-sm">Batal</button>
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded text-sm font-semibold">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // --- 1. LOGIKA TAB ---
        const buttons = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        function showTab(name) {
            contents.forEach(c => c.classList.add('hidden'));
            buttons.forEach(b => b.classList.remove('bg-blue-700', 'ring-2', 'ring-blue-300'));
            
            const target = document.getElementById('tab-' + name);
            if(target) target.classList.remove('hidden');
            
            const activeBtn = document.querySelector(`[data-tab="${name}"]`);
            if(activeBtn) activeBtn.classList.add('bg-blue-700', 'ring-2', 'ring-blue-300');
        }

        buttons.forEach(b => {
            b.addEventListener('click', () => showTab(b.dataset.tab));
        });

        // Set default tab dari controller atau default 'pesanan'
        showTab("{{ $activeTab ?? 'pesanan' }}");

        // --- 2. LOGIKA EDIT PROFIL ---
        const editBtn = document.getElementById('editProfilBtn');
        const cancelBtn = document.getElementById('batalEditBtn');
        const profilView = document.getElementById('profil-view');
        const profilForm = document.getElementById('profil-form');

        if(editBtn) editBtn.onclick = () => { profilView.classList.add('hidden'); profilForm.classList.remove('hidden'); };
        if(cancelBtn) cancelBtn.onclick = () => { profilView.classList.remove('hidden'); profilForm.classList.add('hidden'); };

        // --- 3. LOGIKA MODAL DETAIL ---
        function showDetail(id, total) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');
            content.innerHTML = `
                <div class="flex justify-between"><span>No. Transaksi</span><span class="font-bold">#${id}</span></div>
                <div class="flex justify-between"><span>Status</span><span class="text-green-600 font-bold uppercase text-xs">Berhasil / Selesai</span></div>
                <div class="flex justify-between border-t pt-2"><span>Total Bayar</span><span class="font-bold">Rp${parseInt(total).toLocaleString('id-ID')}</span></div>
                <p class="text-xs text-gray-500 mt-4 italic">* Rincian barang dapat dilihat pada invoice email Anda.</p>
            `;
            modal.classList.remove('hidden');
        }
        function closeDetail() { document.getElementById('detailModal').classList.add('hidden'); }

        // --- 4. LOGIKA MODAL PEMBAYARAN ---
        const addPaymentBtn = document.getElementById('addPaymentBtn');
        const paymentModal = document.getElementById('paymentModal');
        const cancelPaymentBtn = document.getElementById('cancelPaymentBtn');
        const kategoriSelect = document.getElementById('kategoriSelect');
        const extraFields = document.getElementById('extraFields');

        addPaymentBtn.onclick = () => paymentModal.classList.remove('hidden');
        cancelPaymentBtn.onclick = () => paymentModal.classList.add('hidden');

        kategoriSelect.onchange = (e) => {
            extraFields.innerHTML = '';
            if(e.target.value === 'E-Wallet') {
                extraFields.innerHTML = `<input type="text" name="telepon" placeholder="Nomor HP Dana/Ovo" class="w-full text-sm border-gray-300 rounded" required>`;
            } else if(e.target.value === 'Virtual Account') {
                extraFields.innerHTML = `
                    <input type="text" name="bank" placeholder="Nama Bank (BCA/Mandiri)" class="w-full text-sm border-gray-300 rounded mb-2" required>
                    <input type="text" name="norek" placeholder="Nomor Rekening" class="w-full text-sm border-gray-300 rounded" required>
                `;
            }
        };
        kategoriSelect.dispatchEvent(new Event('change')); // trigger default

        function ajukanKomplain(id) {
            alert('Fitur komplain untuk pesanan #' + id + ' sedang diproses oleh admin.');
        }
    </script>
</x-app-layout> 