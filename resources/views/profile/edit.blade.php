<x-app-layout>
    {{-- Background Abu-abu Muda untuk Halaman --}}
    <div class="bg-gray-50 min-h-screen pb-12" style="padding-top: 120px;">
        <div class="max-w-7xl mx-auto px-4 space-y-8">
            
            {{-- HEADER SECTION --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <nav class="flex items-center space-x-2 mb-4 text-sm font-bold text-gray-500">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 hover:text-[#dc2626] transition-all group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#dc2626] transition-colors" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 001 1h3a2 2 0 002-2v-7.586l.293.293a1 1 0 001.414-1.414Z" />
                        </svg>
                        <span class="tracking-wide">Dashboard</span>
                    </a>
                </nav>
                <h2 class="text-3xl font-black text-[#dc2626] uppercase tracking-tighter">
                    Akun Saya
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                {{-- ================= SIDEBAR (Kiri) ================= --}}
                <div class="md:col-span-1">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 sticky top-32">
                        
                        {{-- Header Sidebar (Aksen Merah Muda #fee2e2) --}}
                        <div class="p-6 flex flex-col items-center bg-[#fee2e2] border-b border-[#fecaca]">
                            @php
                                $imagePath = $user->gambar && file_exists(public_path('storage/'.$user->gambar))
                                    ? asset('storage/'.$user->gambar)
                                    : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=dc2626&background=fecaca';
                            @endphp

                            <img src="{{ $imagePath }}" 
                                 alt="Foto Profil" 
                                 class="w-24 h-24 object-cover rounded-full border-4 border-white shadow-md mb-4 ring-2 ring-[#dc2626]">
                            
                            <h3 class="text-lg font-black text-[#5B000B] text-center uppercase tracking-tight">{{ $user->name }}</h3>
                            <p class="text-xs font-bold text-[#b91c1c] text-center break-all">{{ $user->email }}</p>
                        </div>

                        {{-- MENU NAVIGASI SIDEBAR --}}
                        <div class="p-4 space-y-2 bg-white">
                            {{-- Tombol Aktif (Profil) --}}
                            <button class="w-full text-left px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-3 bg-[#dc2626] text-white shadow-lg shadow-red-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil Akun
                            </button>
                            
                            {{-- Tombol Logout (Gradasi Hitam/Putih Style) --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest text-gray-600 hover:bg-gray-900 hover:text-white transition-all flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ================= KONTEN UTAMA (Kanan) ================= --}}
                <div class="md:col-span-3 space-y-6">
                    
                    {{-- 1. Form Update Info --}}
                    <div class="p-8 bg-white shadow-xl rounded-2xl border border-gray-100 hover:border-[#fecaca] transition-colors">
                        <div class="mb-6">
                            <h3 class="text-sm font-black text-[#5B000B] uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 bg-[#dc2626] rounded-full"></span> Informasi Profil
                            </h3>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- 2. Form Update Password --}}
                    @if(view()->exists('profile.partials.update-password-form'))
                        <div class="p-8 bg-white shadow-xl rounded-2xl border border-gray-100 hover:border-[#fecaca] transition-colors">
                            <div class="mb-6">
                                <h3 class="text-sm font-black text-[#5B000B] uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 bg-[#dc2626] rounded-full"></span> Perbarui Kata Sandi
                                </h3>
                            </div>
                            @include('profile.partials.update-password-form')
                        </div>
                    @endif

                    {{-- 3. Form Hapus Akun --}}
                    @if(view()->exists('profile.partials.delete-user-form'))
                        <div class="p-8 bg-white shadow-xl rounded-2xl border-2 border-[#fee2e2] hover:border-[#fecaca] transition-colors">
                            <div class="mb-6">
                                <h3 class="text-sm font-black text-[#b91c1c] uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 bg-[#b91c1c] rounded-full"></span> Zona Bahaya
                                </h3>
                            </div>
                            <div class="bg-[#fee2e2]/30 p-4 rounded-xl">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>