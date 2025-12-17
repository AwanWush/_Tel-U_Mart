@props([
    'harga',
    'diskon' => null,
])

@php
    $hargaAsli = $harga;
    $hargaDiskon = $diskon
        ? $harga - ($harga * ($diskon / 100))
        : null;
@endphp

<div class="space-y-1">
    @if($diskon)
        <div class="flex items-center gap-2">
            <span class="text-2xl font-bold text-red-600">
                Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
            </span>
            <span class="text-sm text-gray-400 line-through">
                Rp {{ number_format($hargaAsli, 0, ',', '.') }}
            </span>
        </div>
        <span class="inline-block text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">
            Hemat {{ $diskon }}%
        </span>
    @else
        <span class="text-2xl font-bold text-blue-600">
            Rp {{ number_format($hargaAsli, 0, ',', '.') }}
        </span>
    @endif
</div>
