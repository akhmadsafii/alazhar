<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CategorySheet implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        return view('export.example.v_category');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 30,
            'D' => 30,
            'E' => 60,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:k2');
        $sheet->mergeCells('A3:k3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text");
        $sheet->mergeCells('A4:k4')->setCellValue('A4', "2. Isi ID Jenis sesuai pada Sheet Jenis Barang.");
        $sheet->mergeCells('A5:k5')->setCellValue('A5', "3. Isi Nama Jenis  agar tidak bingung beserta ID-nya.");
        $sheet->mergeCells('A6:k6')->setCellValue('A6', "4. Isi pada tabel yang sudah disediakan.");
        $sheet->mergeCells('A7:k7');
        $sheet->getStyle('A8:D8')->getFont()->setBold(true);

        $sheet->getStyle('A4')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');
        // $sheet->getStyle('C8')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        // style cells
        $sheet->getStyle('A8:E60')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A7:K7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('80ff0000');
        $sheet->getStyle('A2:K6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
    }
}
