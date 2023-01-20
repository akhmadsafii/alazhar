<?php

namespace App\Imports;

use App\Imports\sample\StuffSample;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StuffImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new StuffSample()
        ];
    }
}
