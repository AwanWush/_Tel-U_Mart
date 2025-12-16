<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Nomor Telepon -->
        <div class="mt-4">
            <x-input-label for="no_telp" :value="__('Nomor Telepon')" />
            <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp" :value="old('no_telp')" placeholder="08xxxxxxxxxx" />
            <x-input-error :messages="$errors->get('no_telp')" class="mt-2" />
        </div>

        <!-- Status Penghuni -->
        <div class="mt-4">
            <x-input-label for="status_penghuni" :value="__('Apakah Anda Penghuni Asrama?')" />
            <select id="status_penghuni" name="status_penghuni" 
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">-- Pilih Status --</option>
                <option value="1" {{ old('status_penghuni') == '1' ? 'selected' : '' }}>Ya, Penghuni Asrama</option>
                <option value="0" {{ old('status_penghuni') == '0' ? 'selected' : '' }}>Bukan Penghuni Asrama</option>
            </select>
            <x-input-error :messages="$errors->get('status_penghuni')" class="mt-2" />
        </div>

        <!-- Pilihan Gedung (Lokasi Delivery) -->
        <div id="lokasi-wrapper" class="mt-4">
            <x-input-label for="lokasi_id" :value="__('Alamat Gedung')" />
            <select id="lokasi_id" name="lokasi_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">-- Pilih Gedung --</option>
                @foreach($lokasi as $lok)
                    <option value="{{ $lok->id }}" {{ old('lokasi_id') == $lok->id ? 'selected' : '' }}>
                        {{ $lok->nama_lokasi }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('lokasi_id')" class="mt-2" />
        </div>

        <!-- Upload Foto Profil -->
        <div class="mt-4">
            <x-input-label for="gambar" :value="__('Foto Profil (Opsional)')" />
            <input id="gambar" type="file" name="gambar" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!--  Script untuk menyembunyikan opsi gedung -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_penghuni');
            const lokasiWrapper = document.getElementById('lokasi-wrapper');
            const lokasiSelect = document.getElementById('lokasi_id');

            function toggleLokasi() {
                if (statusSelect.value === '1') {
                    lokasiWrapper.style.display = 'block';
                } else {
                    lokasiWrapper.style.display = 'none';
                    lokasiSelect.value = ''; // reset pilihan
                }
            }

            statusSelect.addEventListener('change', toggleLokasi);
            toggleLokasi(); 
        });
    </script>
</x-guest-layout>
