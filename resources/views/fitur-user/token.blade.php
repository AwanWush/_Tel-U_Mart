<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                ⚡ <span class="text-blue-500">Token</span> Listrik
            </h2>

            <a href="{{ route('token.history') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gray-800 border border-gray-700 rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Riwayat Transaksi
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-gray-800 via-gray-900 to-black">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" 
             x-data="{ 
                nominal: '', 
                harga: 0, 
                updateHarga(el) {
                    this.nominal = el.value;
                    this.harga = el.options[el.selectedIndex].getAttribute('data-harga');
                }
             }">

            {{-- Card Informasi Pengguna --}}
            <div class="bg-gray-800/40 backdrop-blur-xl p-6 rounded-[2rem] mb-8 text-white border border-white/10 shadow-2xl">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-blue-500/20 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black uppercase tracking-widest text-gray-300">Informasi Penghuni</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-black/20 p-4 rounded-2xl border border-white/5">
                        <p class="text-blue-400 text-[10px] font-black uppercase tracking-widest mb-1">Nama</p>
                        <p class="font-bold text-gray-100">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="bg-black/20 p-4 rounded-2xl border border-white/5">
                        <p class="text-blue-400 text-[10px] font-black uppercase tracking-widest mb-1">Gedung</p>
                        <p class="font-bold text-gray-100">{{ Auth::user()->lokasi->nama_lokasi ?? Auth::user()->alamat_gedung ?? '-' }}</p>
                    </div>
                    <div class="bg-black/20 p-4 rounded-2xl border border-white/5">
                        <p class="text-blue-400 text-[10px] font-black uppercase tracking-widest mb-1">Nomor Kamar</p>
                        <p class="font-bold text-gray-100">{{ Auth::user()->nomor_kamar ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Card Form Pembelian --}}
            <div class="bg-gray-800 p-8 rounded-[2.5rem] shadow-2xl text-white border border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
                
                <h3 class="text-2xl font-black mb-8 flex items-center uppercase tracking-tighter">
                    <span class="bg-blue-600 w-2 h-8 rounded-full mr-3"></span>
                    Beli Token Listrik
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Sisi Kiri: Input --}}
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Pilih Nominal</label>
                            <select name="nominal" id="nominal" @change="updateHarga($el)"
                                class="w-full p-4 bg-gray-900 border border-gray-700 rounded-2xl text-white font-bold focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all appearance-none" required>
                                <option value="" disabled selected>Pilih Paket...</option>
                                @foreach ($tokens as $t)
                                <option value="{{ $t['nominal'] }}" data-harga="{{ $t['harga'] }}">
                                    Rp{{ number_format($t['nominal'], 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Metode Otomatis (Hanya Info) --}}
                        <div class="p-4 bg-blue-600/10 border border-blue-500/30 rounded-2xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold">Pembayaran Aman</p>
                                    <p class="text-[10px] text-gray-400">Diproses otomatis via Midtrans</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Ringkasan Harga --}}
                    <div class="bg-blue-600/5 border border-blue-500/20 rounded-[2rem] p-6 flex flex-col justify-between">
                        <div>
                            <h4 class="text-blue-400 font-black text-xs uppercase tracking-widest mb-4 text-center border-b border-blue-500/10 pb-4">Ringkasan Bayar</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Harga Token:</span>
                                    <span class="font-bold" x-text="nominal ? 'Rp' + parseInt(nominal).toLocaleString('id-ID') : '-'"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Biaya Admin:</span>
                                    <span class="font-bold text-green-400" x-text="harga ? 'Rp' + (harga - nominal).toLocaleString('id-ID') : '-'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 border-t border-blue-500/20 pt-4 text-center">
                            <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">Total Pembayaran</p>
                            <h2 class="text-4xl font-black text-white tracking-tighter" id="displayTotal" x-text="harga ? 'Rp' + parseInt(harga).toLocaleString('id-ID') : 'Rp0'"></h2>
                        </div>
                    </div>
                </div>

                {{-- Tombol Beli --}}
                <div class="pt-6">
                    <button id="payBtn" class="w-full flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-1 active:scale-95 disabled:opacity-50 disabled:translate-y-0"
                            :disabled="!nominal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        BAYAR SEKARANG
                    </button>
                </div>
            </div>
            
            <p class="mt-8 text-center text-gray-600 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART SMART ENERGY</p>
        </div>
    </div>

    {{-- SCRIPT MIDTRANS --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script>
        document.getElementById('payBtn').onclick = async function() {
            const nominal = document.getElementById('nominal').value;
            const harga = document.querySelector(`option[value="${nominal}"]`).getAttribute('data-harga');
            
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...';

            try {
                const response = await fetch("{{ route('payment.snap-token') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        total_amount: harga,
                        type: 'token',
                        nominal: nominal
                    })
                });

                const data = await response.json();

                window.snap.pay(data.snap_token, {
                    onSuccess: (result) => {
                        window.location.href = `/order/success?status=paid&amount=${harga}&type=token&order_id=${data.order_id}`;
                    },
                    onPending: (result) => {
                        window.location.href = `/order/success?status=pending&amount=${harga}&type=token&order_id=${data.order_id}`;
                    },
                    onClose: () => {
                        location.reload();
                    }
                });
            } catch (e) {
                alert('Gagal menghubungi server pembayaran.');
                location.reload();
            }
        };
    </script>
</x-app-layout>