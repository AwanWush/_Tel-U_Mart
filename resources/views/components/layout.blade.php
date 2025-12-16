<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Tel-U Mart' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- HEADER --}}
    <x-header />

    {{-- CONTENT --}}
    <main class="pt-20 pb-20">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <x-footer />

</body>
</html>
