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
    </script>    
</x-app-layout>
