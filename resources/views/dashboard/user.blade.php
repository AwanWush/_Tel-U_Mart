<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Banner Slider --}}
            <x-banner-slider :banners="$banners" />
        </div>
    </x-slot>


    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Welcome + Features --}}
                <x-main-features :latest-products="$latestProducts" />

        </div>
    </div>

    {{-- Product Grid --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 -mt-[150px]">
        <x-product-grid :kategori-produk="$kategoriProduk" />
    </div>

</x-app-layout>
