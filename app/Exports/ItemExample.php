<?php

namespace App\Exports;

use App\Exports\sheet\ItemSheet;
use App\Exports\sheet\LocationSheet;
use App\Exports\sheet\StuffItemSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ItemExample implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ItemSheet();
        $sheets[] = new StuffItemSheet();
        $sheets[] = new LocationSheet();

        return $sheets;
    }
}
