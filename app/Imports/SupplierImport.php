<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SupplierImport implements ToModel, WithHeadingRow,  WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 8;
    }

    public function model(array $row)
    {
        Supplier::create([
            'name' => $row['name'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'description' => $row['description'],
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
            'name.required' => 'Inputan nama satuan harus diisi ',
        ];
    }
}
