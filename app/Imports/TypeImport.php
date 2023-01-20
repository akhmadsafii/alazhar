<?php

namespace App\Imports;

use App\Models\Type;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;

class TypeImport implements ToModel, WithHeadingRow,  WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 8;
    }

    public function model(array $row)
    {
        Type::create([
            'code' => empty($row['code']) ? null : $row['code'],
            'name' => $row['name'],
            'group' => $row['group'],
            'status' => 1
        ]);
    }

    public function rules(): array
    {
        return [
            'group' => 'required',
            'name' => 'required|min:3',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.min' => 'Inputan nama minimal 3 karakter ',
            'name.required' => 'Inputan nama jenis barang harus diisi ',
            'group.required' => 'Inputan tipe jenis barang harus diisi ',
        ];
    }
}
