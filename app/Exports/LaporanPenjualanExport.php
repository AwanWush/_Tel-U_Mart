<?php

namespace App\Exports;

use App\Models\RiwayatPembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class LaporanPenjualanExport implements 
    FromCollection, 
    WithHeadings, 
    WithStyles, 
    WithColumnFormatting, 
    ShouldAutoSize
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
        $data = RiwayatPembelian::where('status', 'Lunas')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($data->isEmpty()) {
            return new Collection([
                [
                    'Tanggal' => '-',
                    'ID Transaksi' => '-',
                    'Metode Pembayaran' => 'Tidak ada data lunas untuk periode ini',
                    'Total' => 0,
                    'Status' => '-',
                ]
            ]);
        }

        return $data->map(function ($item) {
            return [
                'Tanggal' => $item->created_at->format('d-m-Y'),
                'ID Transaksi' => $item->id_transaksi,
                'Metode Pembayaran' => $item->metode_pembayaran,
                'Total' => $item->total_harga,
                'Status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'ID Transaksi',
            'Metode Pembayaran',
            'Total Pembayaran',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = 'E';

        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
        ]);

        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle("A2:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return $sheet;
    }

    // Fungsi yang menyebabkan error tadi sudah diperbaiki namanya:
    public function columnFormats(): array
    {
        return [
            'D' => '"Rp "#,##0', 
        ];
    }
}