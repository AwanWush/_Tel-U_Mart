<x-app-layout>
    <div class="pt-32 py-2 mb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Welcome + Features --}}
                <x-main-features 
                    :banners="$banners"
                    :latest-products="$latestProducts"
                 />

        </div>
    </div>

    {{-- Product Grid --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 -mt-[150px]">
        <x-product-grid :kategori-produk="$kategoriProduk" />
    </div>

</x-app-layout>
