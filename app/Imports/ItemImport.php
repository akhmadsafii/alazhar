<?php

namespace App\Imports;

use App\Imports\sample\ItemSample;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ItemImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ItemSample()
        ];
    }
}
