<?php

namespace App\Exports\sheet;

use App\Models\Type;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TypeSheet implements FromView, WithStyles, ShouldAutoSize, WithColumnWidths
{

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 20,
        ];
    }

    public function view(): View
    {
        $type = Type::where('status', '!=', 0)->get();

        return view('export.sheet.v_type_sheet', compact('type'));
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "Daftar Jenis Barang yang ada di sekolah.");
        $sheet->mergeCells('A4:K4');
        $sheet->getStyle('A3:K3')->getFont()->setBold(true);
        $sheet->getStyle('A6:C6')->getFont()->setBold(true);

        // style cells
        $sheet->getStyle('A6:C300')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A2:K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $sheet->getTabColor()->setRGB('FF0000');
    }
}
