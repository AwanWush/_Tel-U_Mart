<?php

namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // 🔥 Tambahkan ini
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanPenjualanExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnFormatting,
    ShouldAutoSize // 🔥 Daftarkan di sini
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

        if ($data->isEmpty()) {
            return new Collection([
                [
                    'tanggal_penjualan' => '-',
                    'metode_pembayaran' => 'Tidak ada data untuk periode ini',
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

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Styling Header (Baris 1)
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Teks Putih
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'], // Biru Profesional
            ],
        ]);

        // Styling Seluruh Tabel
        $sheet->getStyle("A1:C{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Meratakan teks di tengah untuk kolom A dan B agar lebih rapi
        $sheet->getStyle("A2:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return $sheet;
    }

    public function columnFormats(): array
    {
        return [
            'A' => 'dd/mm/yyyy',
            'C' => '"Rp "#,##0', // Format Rupiah yang lebih proper
        ];
    }
}