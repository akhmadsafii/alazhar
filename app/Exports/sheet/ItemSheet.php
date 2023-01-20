<?php

namespace App\Exports\sheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ItemSheet implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        return view('export.example.v_item');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 20,
            'G' => 20,
            'H' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text");
        $sheet->mergeCells('A4:K4')->setCellValue('A4', "2. Isi ID Barang dan ID Ruang sesuai pada Sheet Daftar Barang dan Ruang.");
        $sheet->mergeCells('A5:K5')->setCellValue('A5', "3. Isi Kondisi dengan salah satu baik, good dan broken.");
        $sheet->mergeCells('A6:K6')->setCellValue('A6', "4. Isi urutan dengan nomor urut berdasarkan item dengan barang yang akan diinput pada database.");
        $sheet->mergeCells('A7:K7')->setCellValue('A7', "5. Format penulisan tanggal dengan YYYY-MM-DD (2022-01-01).");
        $sheet->mergeCells('A8:K8')->setCellValue('A8', "6. Isi Nama Barang dan Nama Lokasi agar tidak bingung beserta ID-nya.");
        $sheet->mergeCells('A9:K9')->setCellValue('A9', "7. Isi pada tabel yang sudah disediakan.");
        $sheet->mergeCells('A10:K10');
        $sheet->getStyle('A11:J11')->getFont()->setBold(true);

        $sheet->getStyle('A4:A7')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        // style cells
        $sheet->getStyle('A11:H60')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A10:K10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('80ff0000');
        $sheet->getStyle('A2:K9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
    }
}
