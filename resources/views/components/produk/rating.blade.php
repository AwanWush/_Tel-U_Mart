@props([
    'rating' => 0,
    'count' => 0,
])

@php
    $ratingRounded = round($rating, 1);
@endphp

<div class="flex items-center gap-2">
    <div class="flex items-center text-yellow-400">
        @for ($i = 1; $i <= 5; $i++)
            @if ($rating >= $i)
                ★
            @elseif ($rating >= $i - 0.5)
                ☆
            @else
                ☆
            @endif
        @endfor
    </div>

    <span class="text-sm text-gray-600">
        {{ $ratingRounded }}/5
        <span class="text-gray-400">
            ({{ $count }} ulasan)
        </span>
    </span>
</div>
