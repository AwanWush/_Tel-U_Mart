@props(['transaksi','filter'=>null])

<table class="w-full text-sm">
    <thead>
        <tr class="text-left border-b">
            <th class="py-2">Produk</th>
            <th class="py-2">Status</th>
            <th class="py-2">Metode</th>
            <th class="py-2">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $rows = collect($transaksi);
            if($filter) {
                $rows = $rows->filter(fn($r) => strtolower($r['status']) === strtolower($filter));
            }
        @endphp

        @forelse($rows as $item)
            <tr class="border-b">
                <td class="py-2">{{ $item['produk'] }}</td>
                <td class="py-2">{{ $item['status'] }}</td>
                <td class="py-2">{{ $item['metode'] }}</td>
                <td class="py-2">Rp {{ number_format($item['total'],0,',','.') }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="py-6 text-center text-gray-500">Belum ada transaksi</td></tr>
        @endforelse
    </tbody>
</table>
