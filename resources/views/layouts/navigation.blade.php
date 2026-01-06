{{-- HEADER UTAMA (SELALU TAMPIL UNTUK SEMUA ROLE) --}}
@include('layouts.partials.header')

{{-- SUB HEADER (HANYA UNTUK USER / role_id = 3) --}}
@if (auth()->check() && auth()->user()->role_id == 3)
    @include('layouts.partials.subheader')
@endif
