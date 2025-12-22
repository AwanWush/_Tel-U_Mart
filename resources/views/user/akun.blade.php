<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Akun Saya
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
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
                                class="tab-btn bg-gray-800 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-700 transition">
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
                    {{-- TAB PESANAN --}}
                    <div id="tab-pesanan" class="tab-content">
                        <div class="border border-gray-200 rounded-lg p-5 bg-white">
                            <h3 class="text-lg font-semibold mb-4">Riwayat Pesanan Saya</h3>

                            <table class="min-w-full text-sm text-gray-700 border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border">No Order</th>
                                        <th class="px-4 py-2 border">Tanggal Order</th>
                                        <th class="px-4 py-2 border">Total Harga</th>
                                        <th class="px-4 py-2 border text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pesanan as $order)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-2 border">{{ $order->nomor_order }}</td>
                                            <td class="px-4 py-2 border">{{ $order->tanggal_order }}</td>
                                            <td class="px-4 py-2 border">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 border text-center space-x-2">
                                                <button onclick="showDetail({{ $order->id }})"
                                                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-500">
                                                    Lihat Detail
                                                </button>
                                                <button onclick="ajukanKomplain({{ $order->id }})"
                                                        class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-400">
                                                    Ajukan Komplain
                                                </button>
                                                <button onclick="beliKembali({{ $order->id }})"
                                                        class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-500">
                                                    Beli Kembali
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-gray-500">
                                                Belum ada pesanan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Modal Detail Pesanan --}}
                            <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                                <div class="bg-white rounded-lg shadow-lg w-96 p-5">
                                    <h4 class="text-lg font-semibold mb-3">Detail Pesanan</h4>
                                    <div id="detailContent" class="text-sm text-gray-700 space-y-2"></div>
                                    <button onclick="closeDetail()"
                                            class="mt-4 bg-gray-800 text-white px-4 py-2 rounded text-sm hover:bg-gray-700 transition">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB PROFIL --}}
                    <div id="tab-profil" class="tab-content hidden">
                        <div class="border border-gray-200 rounded-lg p-5 bg-white">
                            <h3 class="text-lg font-semibold mb-4">Profil Saya</h3>

                            {{-- VIEW PROFIL --}}
                            <div id="profil-view" class="space-y-3">
                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Nomor HP:</strong> {{ $user->no_telp ?? '-' }}</p>
                                @if($user->penghuni_asrama === 'ya')
                                    <p><strong>Gedung:</strong> {{ $user->lokasi->nama_lokasi ?? $user->alamat_gedung ?? '-' }}</p>
                                    <p><strong>Nomor Kamar:</strong> {{ $user->nomor_kamar ?? '-' }}</p>
                                @endif
                                <p><strong>Tanggal Registrasi:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
                                <button id="editProfilBtn"
                                        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-500 transition">
                                    Edit Profil
                                </button>
                            </div>

                            {{-- FORM EDIT PROFIL --}}
                            <div id="profil-form" class="hidden space-y-3">
                                <form action="{{ route('user.akun.update', ['tab' => 'profil']) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')

                                    {{-- NAMA --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="name" value="{{ $user->name }}" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>

                                    {{-- EMAIL --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>

                                    {{-- NOMOR HP --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                        <input type="text" name="no_telp" value="{{ $user->no_telp}}" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>

                                    {{-- PENGHUNI ASRAMA --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Apakah Penghuni Asrama?</label>
                                        <select name="penghuni_asrama" id="penghuni_asrama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="tidak" {{ $user->penghuni_asrama === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            <option value="ya" {{ $user->penghuni_asrama === 'ya' ? 'selected' : '' }}>Ya</option>
                                        </select>
                                    </div>

                                    {{-- ALAMAT GEDUNG --}}
                                    <div id="alamatGedungField" style="display: {{ $user->penghuni_asrama === 'ya' ? 'block' : 'none' }}" class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Alamat Gedung</label>
                                            <select name="lokasi_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="">-- Pilih Gedung --</option>
                                                @foreach($gedungs as $gedung)
                                                    <option value="{{ $gedung->id }}" {{ $user->lokasi_id == $gedung->id ? 'selected' : '' }}>
                                                        {{ $gedung->nama_lokasi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nomor Kamar</label>
                                            <select name="nomor_kamar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="">-- Pilih Nomor Kamar --</option>
                                                @php
                                                    $listKamar = \App\Models\MasterKamar::orderBy('nomor_kamar', 'asc')->get();
                                                @endphp
                                                @foreach($listKamar as $kamar)
                                                    <option value="{{ $kamar->nomor_kamar }}" {{ $user->nomor_kamar == $kamar->nomor_kamar ? 'selected' : '' }}>
                                                        {{ $kamar->nomor_kamar }} (Lantai {{ $kamar->lantai }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- FOTO --}}
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
                                        <input type="file" name="gambar" class="mt-1 block w-full">
                                        @if($user->gambar)
                                            <img src="{{ asset('storage/' . $user->gambar) }}" alt="Foto Profil" class="mt-2 w-24 h-24 object-cover rounded-full">
                                        @endif
                                    </div>

                                    {{-- PASSWORD (optional) --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Password Baru (optional)</label>
                                        <input type="password" name="password" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                               placeholder="Kosongkan jika tidak ingin diganti">
                                    </div>

                                    {{-- KONFIRMASI PASSWORD --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" 
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                               placeholder="Konfirmasi password baru">
                                    </div>
                                    
                                    <div class="flex space-x-2 mt-4">
                                        <button type="submit"
                                                class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-500 transition">
                                            Simpan Perubahan
                                        </button>
                                        <button type="button" id="batalEditBtn"
                                                class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-500 transition">
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
                            <h3 class="text-lg font-semibold mb-4">Metode Pembayaran</h3>

                            {{-- List Metode Pembayaran --}}
                            @if($pembayaran->isEmpty())
                                <p class="text-gray-600 text-sm mb-4">Belum ada metode pembayaran yang ditambahkan.</p>
                            @else
                                <ul class="space-y-2 text-gray-800 text-sm">
                                    @foreach($pembayaran as $pay)
                                        @php
                                            $showPay = true;
                                            if($pay->kategori === 'COD') {
                                                $showPay = $pay->aktif ?? false;
                                            }
                                        @endphp

                                        @if($showPay)
                                            <li class="flex justify-between items-center bg-gray-50 border rounded p-3">
                                                <div>
                                                    <div class="font-semibold">{{ $pay->kategori }}</div>
                                                    @if($pay->keterangan)
                                                        <div class="text-gray-700">{{ $pay->keterangan }}</div>
                                                    @endif
                                                    @if($pay->telepon)
                                                        <div class="text-gray-700">No: {{ $pay->telepon }}</div>
                                                    @endif
                                                    @if($pay->bank)
                                                        <div class="text-gray-700">{{ $pay->bank }} - {{ $pay->norek }}</div>
                                                    @endif
                                                </div>

                                                <form method="POST" action="{{ route('pembayaran.destroy', $pay->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-white hover:bg-red-600 px-3 py-1 text-xs rounded transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif

                            <div id="tab-transaksi" class="tab-content hidden">
                                <div class="border border-gray-200 rounded-lg p-5 bg-white">
                                    <h3 class="text-lg font-semibold mb-4">Transaksi Saya</h3>

                                    {{-- Tabel transaksi dari kode kamu --}}
                                    <x-transaksi-table :transaksi="$transaksi" :filter="($statusFilter ?? null)"/>

                                    {{-- Tombol Bayar Midtrans --}}
                                    @foreach($transaksi as $item)
                                        @if($item->status == 'Menunggu Pembayaran')
                                            <button 
                                                class="px-3 py-2 bg-indigo-600 text-white rounded mt-2 pay-button"
                                                data-id="{{ $item->id }}"
                                                data-amount="{{ $item->total_harga }}">
                                                Bayar Sekarang
                                            </button>
                                        @endif
                                    @endforeach

                                </div>
                            </div>

                            {{-- Tombol Tambah --}}
                            <button id="addPaymentBtn" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-500 transition">
                                Metode Pembayaran Baru
                            </button>

                            {{-- Modal Tambah Metode Pembayaran --}}
                            <div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                                <div class="bg-white rounded-lg shadow-lg w-96 p-5">
                                    <h4 class="text-lg font-semibold mb-3">Tambah Metode Pembayaran</h4>

                                    <form action="{{ route('pembayaran.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                            <select name="kategori" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                            <input type="text" name="telepon"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                placeholder="08xxxxxxxxxx">
                                        </div>

                                        {{-- PILIH BANK UNTUK VIRTUAL ACCOUNT --}}
                                        <div id="bankField" class="mb-3 hidden">
                                            <label class="block text-sm font-medium text-gray-700">Bank</label>
                                            <select name="bank" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="BCA">BCA</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="BRI">BRI</option>
                                                <option value="BNI">BNI</option>
                                            </select>
                                        
                                            <label class="block text-sm font-medium text-gray-700 mt-3">Nomor Rekening</label>
                                            <input type="text" name="norek"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                placeholder="Masukkan nomor rekening">
                                        </div>                                        

                                        <div class="flex justify-end space-x-2">
                                            <button type="button" id="cancelPaymentBtn" class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-500 transition">Batal</button>
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-500 transition">Simpan</button>
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
    
        if(addPaymentBtn){
            addPaymentBtn.addEventListener('click', () => {
                paymentModal.classList.remove('hidden');
            });
        }
    
        if(cancelPaymentBtn){
            cancelPaymentBtn.addEventListener('click', () => {
                paymentModal.classList.add('hidden');
            });
        }
    
        // ================= DETAIL PESANAN =================
        function showDetail(orderId) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');
    
            content.innerHTML = `
                <p><strong>No Order:</strong> #${orderId}</p>
                <p>Produk 1 - 2x - Rp40.000</p>
                <p>Produk 2 - 1x - Rp25.000</p>
                <p class='font-semibold'>Subtotal: Rp65.000</p>
            `;
            modal.classList.remove('hidden');
        }
    
        function closeDetail() {
            document.getElementById('detailModal').classList.add('hidden');
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
            if(!kategoriSelect) return;
    
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
    
        if(kategoriSelect){
            kategoriSelect.addEventListener('change', updateKategoriFields);
            updateKategoriFields(); // trigger default
        }
    </script>  

    <script>
        // === SCRIPT MIDTRANS ===
        document.getElementById('pay-button').addEventListener('click', function () {

            fetch("{{ route('payment.create') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    amount: 20000,
                    transaction_id: 123
                })
            })
            .then(res => res.json())
            .then(data => {
                snap.pay(data.snap_token);
            });

        });
    </script>
    
</x-app-layout>