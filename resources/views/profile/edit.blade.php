<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Akun Saya
        </h2>
    </x-slot>

    {{-- Background Abu-abu Muda untuk Halaman --}}
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                {{-- ================= SIDEBAR (Kiri) ================= --}}
                <div class="md:col-span-1">
                    {{-- Kontainer Sidebar --}}
                    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-xl overflow-hidden transform transition hover:shadow-indigo-300/50">
                        
                        {{-- Header Sidebar (Warna Aksen Indigo) --}}
                        <div class="p-6 flex flex-col items-center bg-indigo-50 dark:bg-indigo-900 border-b border-indigo-100 dark:border-indigo-800">
                            {{-- LOGIKA FOTO PROFIL --}}
                            @php
                                $imagePath = $user->gambar && file_exists(public_path('storage/'.$user->gambar))
                                    ? asset('storage/'.$user->gambar)
                                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF';
                            @endphp

                            <img src="{{ $imagePath }}" 
                                 alt="Foto Profil" 
                                 class="w-24 h-24 object-cover rounded-full border-4 border-white shadow-md mb-4 ring-2 ring-indigo-500">
                            
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white text-center">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">{{ $user->email }}</p>
                        </div>

                        {{-- MENU NAVIGASI SIDEBAR --}}
                        <div class="p-4 space-y-2">
                            {{-- Tombol Aktif (Profil) --}}
                            <button onclick="showTab('profil')" id="btn-profil"
                                class="tab-btn w-full text-left px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-3 
                                       bg-indigo-600 text-white shadow-md hover:bg-indigo-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Profil Akun
                            </button>
                            
                            {{-- Tombol Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-700 transition flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ================= KONTEN UTAMA (Kanan) ================= --}}
                <div class="md:col-span-3">
                    
                    {{-- TAB: PROFIL --}}
                    <div id="tab-profil" class="tab-content space-y-6">
                        
                        {{-- 1. Form Update Info --}}
                        <div class="p-6 bg-white dark:bg-gray-800 shadow-xl rounded-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        {{-- 2. Form Update Password --}}
                        @if(view()->exists('profile.partials.update-password-form'))
                            <div class="p-6 bg-white dark:bg-gray-800 shadow-xl rounded-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        @endif

                        {{-- 3. Form Hapus Akun --}}
                        @if(view()->exists('profile.partials.delete-user-form'))
                            <div class="p-6 bg-white dark:bg-gray-800 shadow-xl rounded-xl border border-red-500/20">
                                @include('profile.partials.delete-user-form')
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>