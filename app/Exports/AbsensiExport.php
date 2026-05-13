<?php

namespace App\Exports;

use App\Models\Absensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected string $filter;
    protected ?string $dari;
    protected ?string $sampai;
    protected int $no = 0;

    public function __construct(string $filter, ?string $dari = null, ?string $sampai = null)
    {
        $this->filter = $filter;
        $this->dari   = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        $query = Absensi::with('user');

        switch ($this->filter) {
            case 'seminggu':
                $query->whereBetween('created_at', [
                    Carbon::now()->subDays(6)->startOfDay(),
                    Carbon::now()->endOfDay(),
                ]);
                break;

            case 'sebulan':
                $query->whereBetween('created_at', [
                    Carbon::now()->subDays(29)->startOfDay(),
                    Carbon::now()->endOfDay(),
                ]);
                break;

            case 'custom':
                if ($this->dari && $this->sampai) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($this->dari)->startOfDay(),
                        Carbon::parse($this->sampai)->endOfDay(),
                    ]);
                }
                break;

            default: 
                $query->whereDate('created_at', Carbon::today());
                break;
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Kurir', 'Email', 'Status Akun', 'Tanggal', 'Jam Masuk', 'Jam Pulang', 'Status Absen', 'Koordinat'];
    }

    public function map($absen): array
    {
        $this->no++;

        return [
            $this->no,
            $absen->user->name  ?? '-',
            $absen->user->email ?? '-',
            ucfirst($absen->user->status ?? 'nonaktif'),
            $absen->created_at
                ? Carbon::parse($absen->created_at)->format('d/m/Y')
                : '-',
            $absen->jam_masuk
                ? Carbon::parse($absen->jam_masuk)->setTimezone('Asia/Jakarta')->format('H:i') . ' WIB'
                : '-',
            $absen->status ?? '-',
            $absen->koordinat_absen ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF5B000B'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Absensi Kurir';
    }
}