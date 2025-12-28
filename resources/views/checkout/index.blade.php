@php

    if (!function_exists('currency')) {

        function currency($a){ return 'Rp '.number_format($a,0,',','.'); }

    }

   

    $user_address = Auth::user()->alamat_gedung ?? "Gedung A, Kamar 001";

@endphp



<x-app-layout>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



<style>

    #map { height:300px; border-radius:16px; border:1px solid #e5e7eb }

    .hidden{ display:none }

   

    /* Perbaikan: Ganti Biru ke Merah Dashboard */

    .btn-active{ background:#dc2626 !important; color:white !important; border-color: #dc2626 !important; }

   

    /* Style Tombol Checkout Utama */

    .btn-pay-highlight { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

    .bg-aktif { background-color: #dc2626 !important; cursor: pointer; box-shadow: 0 4px 14px 0 rgba(220, 38, 38, 0.3); }

    .bg-aktif:hover { background-color: #b91c1c !important; transform: translateY(-2px); }

    .bg-mati { background-color: #d1d5db !important; cursor: not-allowed; }



    /* Samakan style dengan kartu di dashboard */

    .card-modern { @apply bg-white rounded-3xl border border-gray-100 shadow-sm p-6; }

</style>



<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6">

    <nav class="flex text-gray-500 text-sm mb-6" aria-label="Breadcrumb">

        <ol class="inline-flex items-center space-x-1">

            <li class="inline-flex items-center"><a href="/" class="hover:text-red-600">Home</a></li>

            <li><div class="flex items-center"><span class="mx-2">/</span><span class="text-gray-800 font-semibold">Checkout</span></div></li>

        </ol>

    </nav>



    <h1 class="text-3xl font-extrabold mb-8 text-gray-900">Checkout Pesanan</h1>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">



        <div class="lg:col-span-2 space-y-6">

            <div class="card-modern">

                <div class="flex p-1 bg-gray-100 rounded-2xl">

                    {{-- ID Tombol tetap, class disesuaikan agar teks tidak hilang --}}

                    <button id="btnDelivery" class="flex-1 py-3 rounded-xl font-bold btn-active transition-all">Delivery</button>

                    <button id="btnTakeaway" class="flex-1 py-3 rounded-xl font-bold text-gray-500 hover:text-gray-700 transition-all">Takeaway</button>

                </div>

            </div>



            <div id="addressContainer" class="card-modern">

                <div class="flex justify-between items-center mb-4">

                    <h2 class="font-bold text-gray-800 flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                        </svg>

                        Lokasi Pengantaran

                    </h2>

                    <button id="changeAddressBtn" class="text-red-600 text-sm font-bold hover:text-red-800">Ganti Lokasi</button>

                </div>



                <div class="p-4 bg-red-50 rounded-2xl border border-red-100">

                    <p id="displayGedung" class="font-bold text-red-900 text-lg">{{ $user_address }}</p>

                    <p class="text-red-600 text-xs mt-1 italic">*Pastikan nomor kamar sudah benar untuk memudahkan kurir</p>

                </div>



                <div id="addressForm" class="hidden mt-6 space-y-4">

                    <div id="map" class="shadow-inner"></div>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="space-y-1">

                            <label class="text-xs font-bold text-gray-500 ml-1">Pilih Gedung</label>

                            <select id="gedungSelect" onchange="updateMapLocation()" class="w-full rounded-xl border-gray-200 focus:ring-red-500 focus:border-red-500">

                                @foreach(array_merge(array_map(fn($i)=>"Gedung $i",range(1,12)), array_map(fn($l)=>"Gedung $l",range('A','F'))) as $g)

                                    <option {{ $g=='Gedung C'?'selected':'' }}>{{ $g }}</option>

                                @endforeach

                            </select>

                        </div>

                        <div class="space-y-1">

                            <label class="text-xs font-bold text-gray-500 ml-1">No. Kamar</label>

                            <input id="kamarInput" value="304" placeholder="Contoh: 304" class="w-full rounded-xl border-gray-200 focus:ring-red-500 focus:border-red-500">

                        </div>

                    </div>

                    <button onclick="saveNewAddress()" class="w-full bg-red-600 text-white py-3 rounded-xl font-bold shadow-md hover:bg-red-700 transition active:scale-[0.98]">

                        Simpan Perubahan Lokasi

                    </button>

                </div>

            </div>



            <div class="card-modern">

                <h2 class="font-bold text-gray-800 mb-4">Daftar Belanja</h2>

                <div class="space-y-6">

                    @foreach($order_data as $group)

                        <div class="border-b border-gray-50 last:border-0 pb-4 last:pb-0">

                            <div class="flex items-center gap-2 mb-3">

                                <span class="bg-red-100 text-red-600 p-1 rounded-md">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>

                                </span>

                                <p class="font-bold text-gray-700">{{ $group['store'] }}</p>

                            </div>

                            <div class="space-y-3 ml-8">

                                @foreach($group['items'] as $item)

                                    <div class="flex justify-between items-center text-sm">

                                        <div class="flex-1">

                                            <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>

                                            <p class="text-gray-500">{{ $item['qty'] }} barang x {{ currency($item['price']) }}</p>

                                        </div>

                                        <span class="font-bold text-gray-900">{{ currency($item['price'] * $item['qty']) }}</span>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>



        <div class="lg:sticky lg:top-24 space-y-6">

            <div class="card-modern">

                <h2 class="font-bold text-gray-800 mb-6">Ringkasan Belanja</h2>

               

                <div class="space-y-4 mb-6">

                    <div class="flex justify-between text-gray-600">

                        <span>Total Harga Produk</span>

                        <span class="font-medium text-gray-900">{{ currency($subtotal_order) }}</span>

                    </div>

                    <div id="deliveryFeeRow" class="flex justify-between text-gray-600">

                        <span>Ongkos Kirim</span>

                        <span class="font-medium text-gray-900">{{ currency($delivery_fee) }}</span>

                    </div>

                    <div class="flex justify-between text-gray-600 italic">

                        <span>Biaya Layanan</span>

                        <span class="font-medium text-gray-900">{{ currency($service_fee) }}</span>

                    </div>

                </div>



                <div class="border-t border-dashed border-gray-200 pt-4 mb-6">

                    <div class="flex justify-between items-center">

                        <span class="font-bold text-gray-800">Total Tagihan</span>

                        {{-- ID finalPaymentAmount digunakan untuk update harga via JS --}}

                        <span id="finalPaymentAmount" class="font-extrabold text-2xl text-red-600">{{ currency($total_payment) }}</span>

                    </div>

                </div>



                <div class="bg-gray-50 p-3 rounded-xl mb-6">

                    <label class="flex gap-3 text-xs items-start cursor-pointer group">

                        <input type="checkbox" id="terms" class="mt-0.5 rounded border-gray-300 text-red-600 focus:ring-red-500">

                        <span class="text-gray-600 leading-tight group-hover:text-gray-800">

                            Saya setuju dengan <a class="text-red-600 font-bold hover:underline">Syarat & Ketentuan</a> yang berlaku di Tel-U Mart.

                        </span>

                    </label>

                </div>



                <button id="payBtnMencolok" disabled

                    class="btn-pay-highlight bg-mati w-full text-white py-4 rounded-2xl font-black text-lg tracking-wide shadow-lg active:scale-95 uppercase">

                    BUAT PESANAN SEKARANG

                </button>

               

                <p class="text-[10px] text-center text-gray-400 mt-4 px-4">

                    Dengan menekan tombol diatas, pesanan Anda akan langsung diteruskan ke pihak Mart terkait.

                </p>

            </div>

        </div>

    </div>

</div>



<script>

/* Data PHP ke JS untuk perhitungan harga dinamis */

const baseSubtotal = {{ $subtotal_order + $service_fee }};

const deliveryFee = {{ $delivery_fee }};



function formatRupiah(angka) {

    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

}



const asramaCoords={

"Gedung 1":[-6.9710403,107.6283141],"Gedung 2":[-6.9707509,107.6283404],

"Gedung 3":[-6.9704344,107.6283533],"Gedung 4":[-6.9709904,107.6277174],

"Gedung 5":[-6.9706729,107.627767],"Gedung 6":[-6.970935,107.6271111],

"Gedung 7":[-6.9706223,107.6271815],"Gedung 8":[-6.9702831,107.6272323],

"Gedung 9":[-6.9700347,107.6277742],"Gedung 10":[-6.9697409,107.6278167],

"Gedung 11":[-6.9700978,107.6283584],"Gedung 12":[-6.9697555,107.6283976],

"Gedung A":[-6.9740468,107.6285963],"Gedung B":[-6.9736757,107.6286558],

"Gedung C":[-6.9732535,107.6287044],"Gedung D":[-6.9728527,107.6286204],

"Gedung E":[-6.9725544,107.6286242],"Gedung F":[-6.9720839,107.6286579]

};



let map,marker;

function initMap(){

    if(map) return;

    map=L.map('map').setView(asramaCoords["Gedung C"],18);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    marker=L.marker(asramaCoords["Gedung C"]).addTo(map);

}

function updateMapLocation(){

    const g=document.getElementById('gedungSelect').value;

    map.flyTo(asramaCoords[g],18);

    marker.setLatLng(asramaCoords[g]);

}

document.getElementById('changeAddressBtn').onclick=()=>{

    document.getElementById('addressForm').classList.toggle('hidden');

    setTimeout(()=>{initMap();map.invalidateSize()},200);

};



function saveNewAddress() {

    const gedung = document.getElementById('gedungSelect').value;

    const kamar = document.getElementById('kamarInput').value;

    document.getElementById('displayGedung').innerText = `${gedung}, Kamar ${kamar}`;

    document.getElementById('addressForm').classList.add('hidden');

}



const btnDelivery=document.getElementById('btnDelivery');

const btnTakeaway=document.getElementById('btnTakeaway');

const addressContainer=document.getElementById('addressContainer');

const deliveryFeeRow=document.getElementById('deliveryFeeRow');

const finalPriceDisplay=document.getElementById('finalPaymentAmount');



btnDelivery.onclick=()=>{

    // Tampilkan Alamat & Ongkir

    addressContainer.classList.remove('hidden');

    deliveryFeeRow.style.display='flex';

   

    // Toggle Class Aktif (Warna Merah)

    btnDelivery.classList.add('btn-active');

    btnDelivery.classList.remove('text-gray-500');

   

    btnTakeaway.classList.remove('btn-active');

    btnTakeaway.classList.add('text-gray-500');



    // Update Harga (Base + Ongkir)

    finalPriceDisplay.innerText = formatRupiah(baseSubtotal + deliveryFee);

};



btnTakeaway.onclick=()=>{

    // Sembunyikan Alamat & Ongkir

    addressContainer.classList.add('hidden');

    deliveryFeeRow.style.display='none';

   

    // Toggle Class Aktif (Warna Merah)

    btnTakeaway.classList.add('btn-active');

    btnTakeaway.classList.remove('text-gray-500');

   

    // Delivery Tidak Aktif tapi Teks Tetap Ada (Abu-abu)

    btnDelivery.classList.remove('btn-active');

    btnDelivery.classList.add('text-gray-500');



    // Update Harga (Base saja)

    finalPriceDisplay.innerText = formatRupiah(baseSubtotal);

};



const terms = document.getElementById('terms');

const payBtn = document.getElementById('payBtnMencolok');



terms.onchange = () => {

    if (terms.checked) {

        payBtn.disabled = false;

        payBtn.classList.remove('bg-mati');

        payBtn.classList.add('bg-aktif');

    } else {

        payBtn.disabled = true;

        payBtn.classList.remove('bg-aktif');

        payBtn.classList.add('bg-mati');

    }

};



payBtn.onclick = () => {

    const isDelivery = document.getElementById('btnDelivery').classList.contains('btn-active');

    const type = isDelivery ? 'delivery' : 'takeaway';

    // Ambil nilai angka saja dari display harga

    const totalAmount = finalPriceDisplay.innerText.replace(/[^0-9]/g, '');

    window.location.href = `/payment/method?type=${type}&amount=${totalAmount}`;

};

</script>



</x-app-layout>
