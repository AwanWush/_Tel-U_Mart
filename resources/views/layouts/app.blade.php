<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Untuk Icons -->
        <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
          integrity="sha512-..." 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
           @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- ✅ Notifikasi Sukses -->
            @if (session('success'))
                <div 
                    id="successToast"
                    class="fixed bottom-5 right-5 z-50 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-up">
                    <!-- Icon check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>

                <script>
                    // Animasi hilang otomatis setelah 3 detik
                    setTimeout(() => {
                        const toast = document.getElementById('successToast');
                        if (toast) {
                            toast.style.transition = "opacity 0.5s ease";
                            toast.style.opacity = "0";
                            setTimeout(() => toast.remove(), 500);
                        }
                    }, 3000);
                </script>
            @endif

        </div>
    </body>
</html>
