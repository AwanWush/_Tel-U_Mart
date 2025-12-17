@props([
    'stok' => 0,
])

@if($stok > 0)
    <div class="flex items-center gap-1 text-sm text-green-600">
        <span class="font-semibold">Tersedia</span>
        <span class="text-gray-500">
            ({{ $stok }} stok)
        </span>
    </div>
@else
    <div class="text-sm text-red-600 font-semibold">
        Stok Habis
    </div>
@endif
