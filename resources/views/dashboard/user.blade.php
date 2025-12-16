<x-layout>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard Pengguna
            </h2>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-3xl font-extrabold text-white tracking-wide">
                            Hai, <strong>{{ Auth::check() ? Auth::user()->name : 'Pengunjung' }}</strong> 🛒
                        </h3>
                        <p class="mt-2 text-lg text-gray-300">Selamat datang di <b>TJ-T Mart!</b></p>
                    </div>
                    
                    {{-- Tombol Arah ke Fitur --}}
                    <div class="mt-8 flex justify-center gap-4">
    
                        <a href="{{ route('token.index') }}"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            🔌 Beli Token Listrik
                        </a>
    
                        <a href="{{ route('galon.index') }}"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                            🧃 Beli Galon
                        </a>
    
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</x-layout>
