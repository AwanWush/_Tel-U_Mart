<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Tel-U Mart' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* FORCE Z-INDEX: 
               Solusi utama agar dropdown profil dan logout tidak berada di belakang elemen konten 
            */
            #main-nav {
                position: relative;
                z-index: 9999 !important; /* Lapisan tertinggi untuk navigasi */
            }
            
            main {
                position: relative;
                z-index: 10; /* Konten di lapisan bawah */
            }

            /* Mencegah elemen sticky (seperti gambar produk) menimpa navigasi */
            .sticky {
                z-index: 20 !important;
            }

            /* Animasi untuk Toast */
            @keyframes slide-up {
                from { transform: translateY(100%); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            .animate-slide-up {
                animation: slide-up 0.5s ease-out;
            }
        </style>
    </head>

    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col">

            <div id="main-nav">
                @include('layouts.navigation')
            </div>
            
            {{-- HEADER --}}
            @isset($header)
            <header class="bg-white shadow relative z-30">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            {{-- CONTENT --}}
            <main class="pt-0 pb-20">
                {{ $slot }}
            </main>

            @if (session('success'))
                <div id="successToast" 
                     class="fixed bottom-5 right-5 z-[10000] bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center space-x-3 animate-slide-up transition-opacity duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>

                <script>
                    // Menghilangkan toast secara otomatis setelah 3 detik
                    setTimeout(() => {
                        const toast = document.getElementById('successToast');
                        if (toast) {
                            toast.style.opacity = "0";
                            setTimeout(() => toast.remove(), 500);
                        }
                    }, 3000);
                </script>
            @endif

            {{-- FOOTER --}}
            <x-footer />

        </div>
    </body>
</html>