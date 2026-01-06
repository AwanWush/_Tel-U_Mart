<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .bg-custom-red { background-color: #dc2626; }
        .bg-dark-maroon { background-color: #5B000B; }
        .text-accent { color: #E7BD8A; }
        .card-gradient { background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%); }
        /* Animasi halus untuk card */
        .hover-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    </style>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- WELCOME BANNER --}}
            <div class="pt-[60px]">
                <div class="relative overflow-hidden p-10 bg-gradient-to-br from-[#5B000B] via-[#dc2626] to-black rounded-[2rem] shadow-2xl">
                    <div class="relative z-10">
                        <h3 class="text-4xl font-black text-white tracking-tight uppercase">
                            Selamat datang, <span class="text-accent">{{ Auth::user()->name }}</span>
                        </h3>
                        <p class="text-red-100 mt-2 text-lg font-medium opacity-90">Otoritas Penuh Sistem TJ&TMart — Dashboard Superadmin</p>
                    </div>
                    {{-- Dekorasi Abstract --}}
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white opacity-5 rounded-full"></div>
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Unit Mart --}}
                <div class="card-gradient hover-card p-8 rounded-3xl border border-gray-100 shadow-sm border-t-4 border-[#dc2626]">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Unit Mart Aktif</p>
                            <h4 class="text-5xl font-black text-[#5B000B] tracking-tighter">
                                {{ $totalMart }} 
                                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest ml-1">Lokasi</span>
                            </h4>
                        </div>
                        <div class="p-3 bg-red-50 rounded-2xl text-[#dc2626]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Admin Mart --}}
                <div class="card-gradient hover-card p-8 rounded-3xl border border-gray-100 shadow-sm border-t-4 border-orange-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total Admin Mart</p>
                            <h4 class="text-5xl font-black text-orange-600 tracking-tighter">
                                {{ $totalAdmin }}
                                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest ml-1">Personel</span>
                            </h4>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-2xl text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Omzet --}}
                <div class="card-gradient hover-card p-8 rounded-3xl border border-gray-100 shadow-sm border-t-4 border-black">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Omzet Global</p>
                            <h4 class="text-3xl font-black text-gray-900 leading-tight">
                                <span class="text-sm font-bold text-gray-400">Rp</span> {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </h4>
                        </div>
                        <div class="p-3 bg-gray-100 rounded-2xl text-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                {{-- Quick Actions --}}
                <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black text-[#5B000B] mb-6 flex items-center uppercase tracking-tighter">
                      Fitur
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('superadmin.mart.index') }}" class="flex flex-col items-center justify-center p-5 bg-white border-2 border-red-50 rounded-2xl hover:border-[#dc2626] hover:bg-red-50 transition-all group shadow-sm active:scale-95">
                            <i class="fas fa-store text-2xl text-[#dc2626] mb-2 group-hover:scale-110 transition"></i>
                            <span class="font-black text-xs uppercase tracking-widest text-red-700">Kelola Mart</span>
                        </a>

                        <a href="{{ route('admin.manage') }}" class="flex flex-col items-center justify-center p-5 bg-white border-2 border-orange-50 rounded-2xl hover:border-orange-500 hover:bg-orange-50 transition-all group shadow-sm active:scale-95">
                            <i class="fas fa-users-cog text-2xl text-orange-500 mb-2 group-hover:scale-110 transition"></i>
                            <span class="font-black text-xs uppercase tracking-widest text-orange-700">Data Admin</span>
                        </a>

                        <a href="{{ route('gaji.admin') }}" class="flex flex-col items-center justify-center p-5 bg-white border-2 border-gray-100 rounded-2xl hover:border-gray-800 hover:bg-gray-50 transition-all group shadow-sm active:scale-95">
                            <i class="fas fa-money-check-alt text-2xl text-gray-600 mb-2 group-hover:scale-110 transition"></i>
                            <span class="font-black text-xs uppercase tracking-widest text-gray-700">Input Gaji</span>
                        </a>

                        <a href="{{ route('kategori.index') }}" class="flex flex-col items-center justify-center p-5 bg-white border-2 border-yellow-50 rounded-2xl hover:border-yellow-600 hover:bg-yellow-50 transition-all group shadow-sm active:scale-95">
                            <i class="fas fa-tags text-2xl text-yellow-600 mb-2 group-hover:scale-110 transition"></i>
                            <span class="font-black text-xs uppercase tracking-widest text-yellow-700">Kategori</span>
                        </a>
                    </div>
                </div>

                {{-- Chart Section --}}
                <div class="lg:col-span-3 bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-dark-maroon text-white font-black flex justify-between items-center uppercase tracking-widest text-sm">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-chart-line text-accent"></i> Tren Omzet Global (7 Hari)
                        </span>
                    </div>
                    <div class="p-8">
                        <canvas id="omzetChart" style="min-height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('omzetChart').getContext('2d');
            const formatRupiah = (money) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                }).format(money);
            };

            // Gradient background for chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(220, 38, 38, 0.2)');
            gradient.addColorStop(1, 'rgba(220, 38, 38, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Omzet',
                        data: {!! json_encode($totals) !!},
                        borderColor: '#dc2626',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#5B000B',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointHoverBackgroundColor: '#5B000B',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a1a1a',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 14 },
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) { return ' Total: ' + formatRupiah(context.parsed.y); }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                            ticks: {
                                font: { size: 11, weight: '600' },
                                callback: function(value) { return 'Rp ' + value.toLocaleString(); }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11, weight: '600' } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>