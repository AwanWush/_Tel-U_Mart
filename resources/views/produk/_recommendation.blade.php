<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($produk as $item)
        <a href="/produk/{{ $item->id }}"
           class="group block bg-white p-3 rounded-xl shadow hover:shadow-lg transition">

            <div class="relative">
                <img src="{{ asset($item->gambar) }}"
                     class="w-full h-40 object-cover rounded-lg">

                @if($item->persentase_diskon)
                    <span class="absolute top-2 left-2 text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">
                        -{{ $item->persentase_diskon }}%
                    </span>
                @endif
            </div>

            <h3 class="mt-2 text-sm font-semibold line-clamp-2">
                {{ $item->nama_produk }}
            </h3>

            <div class="mt-1 font-bold text-blue-600 text-sm">
                Rp {{ number_format($item->harga, 0, ',', '.') }}
            </div>
        </a>
    @empty
        <p class="text-sm text-gray-500">
            Tidak ada produk serupa.
        </p>
    @endforelse
</div>
