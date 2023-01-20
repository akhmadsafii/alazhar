<?php

namespace App\Imports;

use App\Imports\sample\CategorySample;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CategoryImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new CategorySample()
        ];
    }
}
