<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LocationImport implements ToModel, WithHeadingRow,  WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 8;
    }

    public function model(array $row)
    {
        Location::create([
            'name' => $row['name'],
            'status' => 1
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Inputan nama ruang harus diisi ',
        ];
    }
}
