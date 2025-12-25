@php
    $is_asrama_resident = true;
    $user_address = "Gedung C, Kamar 304";

    $order_data = [
        [
            'store' => 'TMart',
            'items' => [
                ['name' => 'Indomie Goreng Jumbo', 'price' => 3500, 'qty' => 3],
                ['name' => 'Kopi Kapal Api', 'price' => 1500, 'qty' => 5],
            ]
        ],
        [
            'store' => 'TJMart',
            'items' => [
                ['name' => 'Sabun Mandi Cair', 'price' => 18000, 'qty' => 1],
            ]
        ]
    ];

    $subtotal_order = (3*3500)+(5*1500)+18000;
    $delivery_fee = 5000;
    $service_fee = 1000;
    $total_payment = $subtotal_order + $delivery_fee + $service_fee;

    function currency($a){ return 'Rp '.number_format($a,0,',','.'); }
@endphp

<x-app-layout>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #map { height:420px; border-radius:12px; border:2px solid #6366f1 }
    .hidden{ display:none }
    .btn-active{ background:#4f46e5; color:white }

    /* Style Tombol Checkout Utama */
    .btn-pay-highlight { transition: all 0.3s ease; }
    .bg-aktif { background-color: #f97316 !important; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .bg-aktif:hover { background-color: #ea580c !important; transform: translateY(-2px); }
    .bg-mati { background-color: #d1d5db !important; cursor: not-allowed; }

    /* Style Tombol Simpan Lokasi Baru */
    .btn-save-location {
        background-color: #6366f1;
        transition: all 0.2s;
    }
    .btn-save-location:hover {
        background-color: #4f46e5;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="max-w-7xl mx-auto py-10 px-6">
<h1 class="text-3xl font-bold mb-8">Checkout Pesanan</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

<div class="lg:col-span-2 space-y-6">

<div class="bg-white p-6 rounded-xl shadow">
<div class="flex gap-4">
<button id="btnDelivery" class="flex-1 py-3 rounded-lg font-bold btn-active">Delivery</button>
<button id="btnTakeaway" class="flex-1 py-3 rounded-lg font-bold border">Takeaway</button>
</div>
</div>

<div id="addressContainer" class="bg-white p-6 rounded-xl shadow">
<div class="flex justify-between mb-4">
<h2 class="font-bold">Lokasi Pengantaran</h2>
<button id="changeAddressBtn" class="text-indigo-600 text-sm font-semibold hover:underline">Ganti Lokasi</button>
</div>

<p id="displayGedung" class="font-bold text-indigo-700 text-lg">{{ $user_address }}</p>

<div id="addressForm" class="hidden mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
<div id="map" class="mb-4"></div>

<div class="grid grid-cols-2 gap-4">
<select id="gedungSelect" onchange="updateMapLocation()" class="rounded-lg border-gray-300 focus:ring-indigo-500">
@foreach(array_merge(
array_map(fn($i)=>"Gedung $i",range(1,12)),
array_map(fn($l)=>"Gedung $l",range('A','F'))
) as $g)
<option {{ $g=='Gedung C'?'selected':'' }}>{{ $g }}</option>
@endforeach
</select>
<input id="kamarInput" value="304" placeholder="No. Kamar" class="rounded-lg border-gray-300 focus:ring-indigo-500">
</div>

<button onclick="saveNewAddress()"
class="btn-save-location mt-4 w-full text-white py-3 rounded-lg font-bold shadow-md transform active:scale-95">
Simpan Lokasi Baru
</button>
</div>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<h2 class="font-bold mb-4">Daftar Belanja</h2>
@foreach($order_data as $group)
<p class="font-bold text-indigo-600 mt-2">{{ $group['store'] }}</p>
@foreach($group['items'] as $item)
<div class="flex justify-between text-sm py-1 border-b border-gray-50 last:border-0">
<span>{{ $item['name'] }} x{{ $item['qty'] }}</span>
<span>{{ currency($item['price']*$item['qty']) }}</span>
</div>
@endforeach
@endforeach
</div>
</div>

<div class="space-y-6">

<div class="bg-white p-6 rounded-xl shadow">
<div class="flex justify-between"><span>Produk</span><span>{{ currency($subtotal_order) }}</span></div>
<div id="deliveryFeeRow" class="flex justify-between"><span>Ongkir</span><span>{{ currency($delivery_fee) }}</span></div>
<div class="flex justify-between text-gray-500 italic"><span>Layanan</span><span>{{ currency($service_fee) }}</span></div>

<hr class="my-3">

<div class="flex justify-between font-bold text-xl mb-6 text-gray-800">
<span>Total</span>
<span id="finalPaymentAmount">{{ currency($total_payment) }}</span>
</div>

<label class="flex gap-2 text-sm mb-4 items-center cursor-pointer">
<input type="checkbox" id="terms" class="rounded text-indigo-600 focus:ring-indigo-500">
<span class="text-gray-700">Saya setuju <a class="text-indigo-600 hover:underline">Syarat & Ketentuan</a></span>
</label>

<div class="block w-full">
    <button id="payBtnMencolok"
        disabled
        class="btn-pay-highlight bg-mati w-full text-white py-4 rounded-xl font-extrabold text-xl transform active:scale-95 shadow-md">
        BUAT PESANAN
    </button>
</div>

</div>
</div>
</div>
</div>

<script>
/* ================= MAP LOGIC ================= */
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

/* ================= FUNGSI SIMPAN LOKASI ================= */
function saveNewAddress() {
    const gedung = document.getElementById('gedungSelect').value;
    const kamar = document.getElementById('kamarInput').value;
    
    // 1. Update teks alamat di tampilan utama
    document.getElementById('displayGedung').innerText = `${gedung}, Kamar ${kamar}`;
    
    // 2. Sembunyikan form map kembali
    document.getElementById('addressForm').classList.add('hidden');
    
    // 3. Optional: Beri feedback sukses (alert atau toast)
    console.log("Alamat diperbarui ke:", gedung, kamar);
}

/* ================= DELIVERY / TAKEAWAY ================= */
const btnDelivery=document.getElementById('btnDelivery');
const btnTakeaway=document.getElementById('btnTakeaway');
const addressContainer=document.getElementById('addressContainer');
const deliveryFeeRow=document.getElementById('deliveryFeeRow');

btnDelivery.onclick=()=>{
    addressContainer.style.display='block';
    deliveryFeeRow.style.display='flex';
    btnDelivery.classList.add('btn-active');
    btnTakeaway.classList.remove('btn-active');
};

btnTakeaway.onclick=()=>{
    addressContainer.style.display='none';
    deliveryFeeRow.style.display='none';
    btnTakeaway.classList.add('btn-active');
    btnDelivery.classList.remove('btn-active');
};

/* ================= LOGIKA GANTI TOMBOL CHECKOUT ================= */
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

payBtn.onclick = () => window.location.href='/order/confirm';
document.getElementById('payBtnMencolok').addEventListener('click', function() {
    // Ambil tipe yang sedang aktif (cek class btn-active pada tombol delivery)
    const isDelivery = document.getElementById('btnDelivery').classList.contains('btn-active');
    const type = isDelivery ? 'delivery' : 'takeaway';

    // Arahkan ke halaman metode dengan parameter type
    window.location.href = `/payment/method?type=${type}`;
});
</script>

</x-app-layout>