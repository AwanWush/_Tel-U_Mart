<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                          class="block mt-1 w-full" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <!-- Input password -->
                <x-text-input id="password" 
                              class="block mt-1 w-full pr-10"
                              type="password"
                              name="password"
                              required 
                              autocomplete="current-password" />

                <!-- Tombol Mata di Dalam Kotak (Kanan Atas) -->
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                    
                    <!-- Mata Terbuka -->
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" 
                         class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M2.458 12C3.732 7.943 7.523 5 12 5
                                 c4.477 0 8.268 2.943 9.542 7
                                 -1.274 4.057-5.065 7-9.542 7
                                 -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <!-- Mata Tertutup -->
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" 
                         class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.875 18.825A10.05 10.05 0 0112 19
                                 c-4.477 0-8.268-2.943-9.542-7
                                 a9.97 9.97 0 012.168-3.507M9.88 9.88
                                 a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Tombol Login -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if (Route::has('password.request'))
                    {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md 
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a> --}}
                @endif
            </div>

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Tambahan: Link ke halaman register -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" 
                   class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    </script>
</x-guest-layout>
