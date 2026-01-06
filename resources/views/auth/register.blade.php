<x-guest-layout>
    <div x-data="{
        isAsrama: '{{ old('status_penghuni') }}',
        showPassword: false,
        loading: false,
        photoPreview: null,
    
        updatePreview(event) {
            const file = event.target.files[0];
            if (file) {
                this.photoPreview = URL.createObjectURL(file);
            }
        }
    }" class="fixed inset-0 z-50 flex bg-white font-sans overflow-hidden">

        {{-- BAGIAN KIRI: BRANDING (Style: Hitam-Merah & Blur - Sesuai Login) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-black h-full overflow-hidden">
            {{-- Gambar dengan filter Blur sesuai request visual --}}
            <img src="https://images.unsplash.com/photo-1580913428706-c311ab527eb3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                class="absolute inset-0 w-full h-full object-cover opacity-40 blur-md scale-110"
                alt="Background Register">

            {{-- Overlay gradasi hitam agar teks lebih terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>

            <div class="relative z-10 w-full flex flex-col justify-between p-12 xl:p-16 text-white h-full">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="h-10 w-20 bg-[#d50d27] rounded-xl flex items-center justify-center shadow-lg shadow-[#d50d27]/40">
                            <span class="text-xl font-bold">TJ&T</span>
                        </div>
                        <span class="text-lg font-semibold tracking-wide">Mart</span>
                    </div>

                    <h1 class="text-4xl xl:text-5xl font-bold leading-tight mb-4">
                        Bergabunglah dengan<br>Komunitas Kami.
                    </h1>
                    <p class="text-gray-300 text-base xl:text-lg max-w-md">
                        Dapatkan akses eksklusif ke promo asrama, pengiriman cepat, dan kemudahan belanja harian.
                    </p>

                    {{-- BADGE JAM BUKA (Style Merah) --}}
                    <div class="mt-6 inline-block">
                        <div
                            class="flex items-center gap-2 px-4 py-2 bg-[#d50d27]/20 backdrop-blur-md border border-[#d50d27]/50 rounded-lg text-[#d50d27] font-bold text-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Buka: 08:00 - 21:00 WIB</span>
                        </div>
                    </div>
                </div>

                {{-- STATISTIK (Style Putih sesuai Login) --}}
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

        {{-- BAGIAN KANAN: FORM REGISTER (Struktur Kode Asli Dipertahankan) --}}
        <div class="w-full lg:w-1/2 h-full bg-gray-50 overflow-y-auto">

            <div class="min-h-full flex flex-col justify-center py-10 px-6 sm:px-12 lg:px-16 xl:px-20">

                {{-- Header Form --}}
                <div class="mb-6 text-center lg:text-left">
                    <h2 class="text-2xl xl:text-3xl font-bold text-gray-900">Buat Akun Baru 🚀</h2>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi data diri Anda untuk memulai.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                    @submit="loading = true" class="space-y-4">
                    @csrf

                    {{-- 1. Nama Lengkap (REVISI: value diubah agar stabil dengan old()) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2.5 px-4 text-sm"
                            placeholder="Nama sesuai KTM">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- 2. Email & No Telp (Grid) (REVISI: value diubah agar stabil dengan old()) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2.5 px-4 text-sm"
                                placeholder="email@gmail...">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">No. WhatsApp</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" required
                                class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2.5 px-4 text-sm"
                                placeholder="0812...">
                            <x-input-error :messages="$errors->get('no_telp')" class="mt-1" />
                        </div>
                    </div>

                    {{-- 3. Status Penghuni (Logic Alpine) --}}
                    <div class="bg-gray-100 p-4 rounded-xl border border-gray-200">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Tempat Tinggal</label>

                        <div class="flex gap-4 mb-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status_penghuni" value="1" x-model="isAsrama"
                                    class="text-[#d50d27] focus:ring-[#d50d27]">
                                <span class="text-sm font-medium text-gray-700">Penghuni Asrama</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status_penghuni" value="0" x-model="isAsrama"
                                    class="text-[#d50d27] focus:ring-[#d50d27]">
                                <span class="text-sm font-medium text-gray-700">Luar Asrama</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('status_penghuni')" class="mt-1" />

                        {{-- Dropdown Gedung & Kamar (Struktur Asli) --}}
                        <div x-show="isAsrama == '1'" x-transition.opacity.duration.300ms
                            class="mt-3 border-t border-gray-200 pt-3 space-y-3">

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Pilih
                                    Gedung Asrama</label>
                                <select name="lokasi_id"
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2 px-3 bg-white text-sm">
                                    <option value="">-- Pilih Gedung --</option>
                                    @foreach ($lokasi as $lok)
                                        <option value="{{ $lok->id }}"
                                            {{ old('lokasi_id') == $lok->id ? 'selected' : '' }}>
                                            {{ $lok->nama_lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('lokasi_id')" class="mt-1" />
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Pilih
                                    Nomor Kamar</label>
                                <select name="nomor_kamar"
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2 px-3 bg-white text-sm">
                                    <option value="">-- Pilih Nomor Kamar --</option>
                                    @php
                                        $masterKamars = \App\Models\MasterKamar::orderBy('nomor_kamar', 'asc')->get();
                                    @endphp
                                    @foreach ($masterKamars as $kamar)
                                        <option value="{{ $kamar->nomor_kamar }}"
                                            {{ old('nomor_kamar') == $kamar->nomor_kamar ? 'selected' : '' }}>
                                            {{ $kamar->nomor_kamar }} (Lantai {{ $kamar->lantai }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('nomor_kamar')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- 4. Foto Profil --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Foto Profil (Opsional)</label>
                        <div class="flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 overflow-hidden flex-shrink-0 border border-gray-300">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <svg class="h-full w-full text-gray-400 p-2" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </template>
                            </div>
                            <input type="file" name="gambar" accept="image/*" @change="updatePreview"
                                class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#d50d27]/10 file:text-[#d50d27] hover:file:bg-[#d50d27]/20 cursor-pointer">
                        </div>
                        <x-input-error :messages="$errors->get('gambar')" class="mt-1" />
                    </div>

                    {{-- 5. Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2.5 px-4 pr-10 text-sm">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#d50d27] focus:outline-none">
                                    <svg x-show="!showPassword" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" style="display: none;" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.168-3.507M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Pass</label>
                            <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" required
                                class="w-full border-gray-300 rounded-lg focus:ring-[#d50d27] focus:border-[#d50d27] py-2.5 px-4 text-sm">
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-[#d50d27]/30 text-sm font-bold text-white bg-[#d50d27] hover:bg-black transition-all duration-200 transform hover:-translate-y-0.5"
                            :disabled="loading">
                            <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            <span x-text="loading ? 'Mendaftarkan Akun...' : 'Daftar Sekarang'"></span>
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="font-bold text-[#d50d27] hover:underline transition">
                                Masuk Disini
                            </a>
                        </p>
                    </div>
                </form>

                <div class="mt-8 text-center pb-4">
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} TJ-T Mart. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>