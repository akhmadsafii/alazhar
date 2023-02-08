<?php

namespace App\Exports;

use App\Exports\sheet\CategorySheet;
use App\Exports\sheet\TypeSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CategoryExample implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new CategorySheet();
        $sheets[] = new TypeSheet();

        return $sheets;
    }
}
