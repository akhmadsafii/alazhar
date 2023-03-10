<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class SupplierExample implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        return view('export.example.v_supplier');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 50,
            'D' => 50,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text");
        $sheet->mergeCells('A4:K4')->setCellValue('A4', "2. Isi pada tabel yang sudah disediakan.");
        $sheet->mergeCells('A5:K5')->setCellValue('A5', "3. Kolom nama suplayer wajib diisi.");
        $sheet->mergeCells('A6:K6');
        $sheet->getStyle('A7:D7')->getFont()->setBold(true);

        $sheet->getStyle('A5')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        // style cells
        $sheet->getStyle('A7:D50')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A2:K6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
    }
}
