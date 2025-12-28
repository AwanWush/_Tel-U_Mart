<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-gray-800 via-gray-900 to-black">
        <div class="max-w-xl mx-auto px-4">
            <div class="bg-gray-800/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/10 shadow-2xl text-center">
                
                <div class="inline-flex p-4 bg-green-500/20 rounded-full mb-6 border border-green-500/30">
                    <svg class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="text-3xl font-black mb-2 text-white uppercase tracking-tighter">Pembelian Berhasil</h2>
                <p class="text-gray-400 text-sm mb-8 italic">Silakan masukkan kode di bawah ke meteran listrik Anda.</p>

                {{-- Box Token Utama --}}
                <div class="bg-black/40 p-6 rounded-3xl border border-blue-500/30 mb-8 relative overflow-hidden group">
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3">Nomor Token Listrik</p>
                    <h1 class="text-3xl md:text-4xl font-mono font-black text-white tracking-[0.15em]" id="tokenValue">
                        {{ $nomor_token }}
                    </h1>
                    {{-- Tombol Copy --}}
                    <button onclick="copyToken('{{ str_replace('-', '', $nomor_token) }}')" class="mt-4 text-xs font-bold text-gray-500 hover:text-white transition uppercase tracking-widest flex items-center justify-center gap-2 mx-auto">
                        <i class="fas fa-copy"></i> Salin Kode
                    </button>
                </div>

                <div class="space-y-3 text-left bg-black/20 p-6 rounded-2xl border border-white/5 mb-8">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Nominal:</span>
                        <span class="text-white font-bold">Rp{{ number_format($amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Waktu:</span>
                        <span class="text-white font-bold">{{ date('d M Y, H:i') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button onclick="window.print()" class="py-4 bg-gray-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-600 transition">Cetak</button>
                    <a href="{{ route('token.index') }}" class="py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-500 transition shadow-lg shadow-blue-600/20">Selesai</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToken(text) {
            navigator.clipboard.writeText(text);
            alert('Nomor token berhasil disalin!');
        }
    </script>
</x-app-layout>