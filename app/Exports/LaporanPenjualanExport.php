<?php

namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPenjualanExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $data = Penjualan::whereMonth('tanggal_penjualan', $this->bulan)
            ->whereYear('tanggal_penjualan', $this->tahun)
            ->select('tanggal_penjualan', 'metode_pembayaran', 'total')
            ->get();

        // 🔥 JIKA DATA KOSONG → TETAP EXPORT
        if ($data->isEmpty()) {
            return new Collection([
                [
                    'tanggal_penjualan' => '-',
                    'metode_pembayaran' => 'Tidak ada data',
                    'total' => 0,
                ]
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal Penjualan',
            'Metode Pembayaran',
            'Total Pembayaran',
        ];
    }
}
