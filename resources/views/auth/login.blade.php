<x-guest-layout>
    {{-- 
        LAYOUT LOGIN (WARNA MERAH-HITAM & BLUR IMAGE)
    --}}
    <div x-data="{ 
            showPassword: false, 
            loading: false 
         }" 
         class="fixed inset-0 z-50 flex bg-white font-sans overflow-hidden">

        {{-- BAGIAN KIRI: BRANDING (Dark Theme with Blur) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-black h-full overflow-hidden">
            {{-- Gambar dengan filter Blur dan Grayscale sedikit agar menyatu dengan Hitam --}}
            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-40 blur-md scale-110" 
                 alt="Background Login">
            
            {{-- Overlay gradasi hitam agar teks lebih terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>

            <div class="relative z-10 w-full flex flex-col justify-between p-12 xl:p-16 text-white h-full">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 bg-[#d50d27] rounded-xl flex items-center justify-center shadow-lg shadow-[#d50d27]/40">
                            <span class="text-xl font-bold">TJ</span>
                        </div>
                        <span class="text-lg font-semibold tracking-wide">TJ-T Mart</span>
                    </div>
                    
                    <h1 class="text-4xl xl:text-5xl font-bold leading-tight mb-4">
                        Selamat Datang<br>Kembali!
                    </h1>
                    <p class="text-gray-300 text-base xl:text-lg max-w-md">
                        Masuk untuk melanjutkan belanja kebutuhan asrama Anda dengan mudah dan hemat.
                    </p>

                    {{-- BADGE JAM BUKA --}}
                    <div class="mt-6 inline-block">
                        <div class="flex items-center gap-2 px-4 py-2 bg-[#d50d27]/20 backdrop-blur-md border border-[#d50d27]/50 rounded-lg text-[#d50d27] font-bold text-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Buka: 08:00 - 21:00 WIB</span>
                        </div>
                    </div>
                </div>

                {{-- STATISTIK --}}
                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-2xl font-bold text-[#FFFFFF]">08:00 - 21:00</p>
                        <p class="text-sm text-gray-400 mt-1">Jam Operasional</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#FFFFFF]">100%</p>
                        <p class="text-sm text-gray-400 mt-1">Produk Terjamin</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM LOGIN (Putih Bersih) --}}
        <div class="w-full lg:w-1/2 h-full bg-white overflow-y-auto overflow-x-hidden relative flex items-center">
            
            <div class="w-full py-10 px-6 sm:px-12 lg:px-16 xl:px-20">
                
                {{-- Header Form --}}
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Masuk Akun</h2>
                    <p class="text-sm text-gray-500 mt-2">Gunakan akun terdaftar Anda untuk mulai berbelanja.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" @submit="loading = true" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-[#d50d27] focus:border-[#d50d27] focus:bg-white transition-all py-3 px-4 text-sm shadow-sm"
                               placeholder="Masukkan email Anda">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-bold text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-[#d50d27] hover:underline" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                                   class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-[#d50d27] focus:border-[#d50d27] focus:bg-white transition-all py-3 px-4 pr-12 text-sm shadow-sm"
                                   placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#d50d27]">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="showPassword" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.168-3.507M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#d50d27] shadow-sm focus:ring-[#d50d27] cursor-pointer w-4 h-4" name="remember">
                            <span class="ml-2 text-sm text-gray-500 group-hover:text-gray-900 transition">Ingat Saya</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-xl shadow-[#d50d27]/20 text-sm font-bold text-white bg-[#d50d27] hover:bg-black transition-all duration-300 transform active:scale-[0.98]"
                                :disabled="loading">
                            <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                            <span x-text="loading ? 'Memverifikasi...' : 'Masuk Sekarang'"></span>
                        </button>
                    </div>

                    {{-- Link Daftar --}}
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-[#d50d27] hover:underline">
                                Daftar Disini
                            </a>
                        </p>
                    </div>
                </form>
                
                <div class="mt-12 text-center">
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold">&copy; {{ date('Y') }} TJ-T Mart. Excellence in Service.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>