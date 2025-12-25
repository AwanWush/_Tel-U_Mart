<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Banner Slider --}}
        <x-banner-slider :banners="$banners" />
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Welcome + Features --}}
                <x-main-features :latest-products="$latestProducts" />

        </div>
    </div>

    {{-- Product Grid --}}
    <x-product-grid :kategori-produk="$kategoriProduk" />

</x-app-layout>
