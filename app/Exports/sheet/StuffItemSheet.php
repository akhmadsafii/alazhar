<?php

namespace App\Exports\sheet;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StuffItemSheet implements FromView, WithStyles, ShouldAutoSize, WithColumnWidths
{

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 20,
            'D' => 30,
            'E' => 30,
            'F' => 20,
        ];
    }

    public function view(): View
    {
        $stuffs = DB::table('stuffs as st')
            ->join('units as un', 'un.id', '=', 'st.id_unit')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->join('categories as ct', 'ct.id', '=', 'st.id_category')
            ->join('suppliers as sp', 'sp.id', '=', 'st.id_supplier')
            ->where('st.status', '!=', 0)
            ->select(
                'st.*',
                'tp.name as type',
                'tp.group as group',
                'ct.name as category',
                'un.name as unit',
                'sp.name as supplier',
            )->get();

        return view('export.sheet.v_stuff_sheet', compact('stuffs'));
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "Daftar Barang yang ada di sekolah.");
        $sheet->mergeCells('A4:K4');
        $sheet->getStyle('A3:K3')->getFont()->setBold(true);
        $sheet->getStyle('A6:H6')->getFont()->setBold(true);

        // style cells
        $sheet->getStyle('A6:H300')->applyFromArray([
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
