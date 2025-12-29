<x-app-layout>
    {{-- Custom Stylesheet dari halaman token --}}
    <style>
        .bg-primary-accent { background-color: #DB4B3A; }
        .text-primary-accent { color: #DB4B3A; }
        .border-primary-accent { border-color: #DB4B3A; }
        
        /* WARNA UTAMA */
        .bg-red-main { background-color: #dc2626; }
        .text-red-main { color: #dc2626; }
        .border-red-main { border-color: #dc2626; }
        
        .hover\:bg-red-hover:hover { background-color: #b91c1c; }
        .shadow-red-soft { box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15); }
        .bg-red-soft { background-color: #fee2e2; }
        .border-soft-accent { border-color: #E7BD8A; }

        /* Styling Struk/Card Utama Hasil: Menggunakan gaya card ringan dan struk */
        .receipt-container {
            background-color: #ffffff; 
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.1); 
            border-radius: 2.5rem; /* Mirip dengan card di token */
            border: 2px solid #fca5a5; /* border-red-300 */
        }
        
        /* Efek sobekan kertas atas/bawah (untuk visual hasil) */
        .receipt-top-tear {
            border-top: 3px dashed #fca5a5; /* border-red-300 */
            position: relative;
            margin: 1.5rem 0;
        }
        
        .receipt-top-tear::before, .receipt-top-tear::after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background-color: #f9fafb; /* Sesuaikan dengan bg outer div */
            border: 2px solid #fca5a5;
            border-radius: 50%;
            z-index: 10;
        }
        .receipt-top-tear::before {
            left: -10px;
        }
        .receipt-top-tear::after {
            right: -10px;
        }
        /* Ganti bg-gray-50 di struk dengan bg-white atau #f9fafb agar lubang terlihat */
        .receipt-content-bg {
            background-color: #f9fafb;
        }

        /* Styling untuk tombol Selesai/Kembali */
        .btn-pay-red {
            background-color: #dc2626; /* bg-red-main */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(0);
        }
        .btn-pay-red:hover {
            background-color: #b91c1c; /* hover:bg-red-hover */
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4); 
            transform: translateY(-2px);
        }

        /* Styling untuk tombol Cetak */
        .btn-print-style {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-print-style:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        /* Menghilangkan elemen saat print */
        @media print {
            /* Sembunyikan tombol cetak dan selesai */
            .print-hidden {
                display: none !important;
            }
            /* Ubah latar belakang card utama menjadi putih */
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
            }
            /* Hilangkan dekorasi sobekan jika diperlukan */
            .receipt-top-tear {
                border-top: none !important;
                margin: 0 !important;
            }
            .receipt-top-tear::before, .receipt-top-tear::after {
                display: none !important;
            }
        }
    </style>

    {{-- Header untuk Light Mode (Diperlukan untuk konsistensi) --}}
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tight uppercase">
                <span class="text-primary-accent">Token</span> Listrik
            </h2>
        </div>
    </x-slot>

    {{-- Background Utama: Putih Bersih (Sesuai halaman token) --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto px-4">
            {{-- Card Utama Hasil Pembelian: Menggunakan gaya receipt-container --}}
            <div class="receipt-container bg-white p-8 md:p-10 rounded-[2.5rem] text-center shadow-xl">
                
                {{-- Icon Sukses: Diubah ke warna merah utama --}}
                <div class="inline-flex p-4 bg-red-soft rounded-full mb-6 border-4 border-red-200/50 shadow-lg shadow-red-main/10">
                    <svg class="h-12 w-12 text-red-main" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h2 class="text-3xl font-black mb-2 text-gray-900 uppercase tracking-tighter">Pembelian Berhasil</h2>
                <p class="text-gray-500 text-sm mb-8 italic">Simpan dan masukkan kode di bawah ke meteran listrik Anda.</p>
                
                {{-- Separator Dashed baru dengan efek sobekan --}}
                <div class="mb-8 receipt-top-tear"></div> 

                {{-- Box Token Utama: Diubah ke gaya yang lebih seragam --}}
                <div class="bg-red-soft p-6 rounded-3xl border-2 border-red-main/50 mb-8 relative overflow-hidden group shadow-inner shadow-red-main/10">
                    <p class="text-[10px] font-black text-red-main uppercase tracking-[0.2em] mb-3">Nomor Token Listrik</p>
                    <h1 class="text-3xl md:text-4xl font-mono font-black text-gray-900 tracking-[0.15em]" id="tokenValue">
                        {{ $nomor_token }}
                    </h1>
                    {{-- Tombol Copy --}}
                    <button onclick="copyToken('{{ str_replace('-', '', $nomor_token) }}')" class="mt-4 text-xs font-bold text-gray-500 hover:text-red-main transition uppercase tracking-widest flex items-center justify-center gap-2 mx-auto active:scale-[0.98]">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v7a2 2 0 002 2h7m-5-5l5-5m0 0h-5m5 0v5"></path></svg>
                        Salin Kode
                    </button>
                </div>

                {{-- Detail Transaksi: Diubah ke gaya yang lebih seragam --}}
                <div class="space-y-3 text-left bg-gray-50 p-6 rounded-2xl border border-gray-200 mb-8 shadow-sm">
                    <div class="flex justify-between text-sm items-center">
                        <span class="text-gray-500 font-medium">Nominal Pembelian:</span>
                        <span class="text-red-main font-extrabold text-lg">Rp{{ number_format($amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm items-center border-t border-dashed pt-3">
                        <span class="text-gray-500 font-medium">Waktu Transaksi:</span>
                        <span class="text-gray-800 font-bold text-sm">{{ date('d M Y, H:i') }}</span>
                    </div>
                </div>

                {{-- Tombol Aksi: Menggunakan style btn-pay-red untuk "Selesai" --}}
                <div class="grid grid-cols-2 gap-4 print-hidden">
                    <button onclick="window.print()" class="btn-print-style py-4 bg-gray-200 text-gray-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-300 transition hover:shadow-lg active:scale-[0.98]">
                        <i class="fas fa-print"></i> CETAK
                    </button>
                    <a href="{{ route('token.index') }}" class="btn-pay-red py-4 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-red-main/20 hover:shadow-xl hover:shadow-red-main/30 active:scale-[0.98]">
                        <i class="fas fa-home"></i> SELESAI
                    </a>
                </div>

            </div>
            
            <p class="mt-8 text-center text-gray-400 text-[10px] font-black uppercase tracking-[0.5em]">&copy; 2025 TJ-T MART SMART ENERGY</p>
        </div>
    </div>

    <script>
        function copyToken(text) {
            // Hilangkan semua spasi dan tanda hubung
            const cleanedText = text.replace(/[-\s]/g, ''); 
            navigator.clipboard.writeText(cleanedText);
            
            const button = document.querySelector('button[onclick^="copyToken"]');
            const originalText = button.innerHTML;

            button.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Disalin!';
            
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);
        }
    </script>
</x-app-layout>