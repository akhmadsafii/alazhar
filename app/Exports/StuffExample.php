<?php

namespace App\Exports;

use App\Exports\sheet\CategoryStuffSheet;
use App\Exports\sheet\StuffSheet;
use App\Exports\sheet\SupplierSheet;
use App\Exports\sheet\UnitSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StuffExample implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new StuffSheet();
        $sheets[] = new CategoryStuffSheet();
        $sheets[] = new UnitSheet();
        $sheets[] = new SupplierSheet();

        return $sheets;
    }
}
