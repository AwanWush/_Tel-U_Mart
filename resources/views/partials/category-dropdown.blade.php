<div class="relative group">

    {{-- TRIGGER --}}
    <button
        class="px-4 py-2 rounded-full text-sm font-medium
               text-black
               hover:bg-[#E7BD8A]/40
               hover:text-[#DB4B3A]
               transition flex items-center gap-1"
    >
        Kategori
        <i class="fa-solid fa-chevron-down text-xs"></i>
    </button>

    {{-- DROPDOWN --}}
    <div
        class="absolute left-0 mt-2 w-56
               bg-white border border-gray-200
               rounded-xl shadow-lg
               opacity-0 invisible
               group-hover:opacity-100 group-hover:visible
               transition-all duration-200
               z-50"
    >
        <ul class="py-2 text-sm text-gray-700">
            @foreach ($kategoriList as $kategori)
                <li>
                    <a
                        href="{{ route('produk.index', ['kategori' => $kategori->id]) }}"
                        class="block px-4 py-2 hover:bg-[#E7BD8A]/30 hover:text-[#DB4B3A] transition"
                    >
                        {{ $kategori->nama_kategori }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

</div>
