<?php

namespace App\Imports\sample;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;;

class CategorySample implements ToModel, WithHeadingRow,  WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 9;
    }

    public function model(array $row)
    {
        // dd($row);
        Category::create([
            'code' => $row['code'],
            'id_type' => $row['id_type'],
            'name' => $row['name'],
            'description' => $row['description'],
            'status' => 1
        ]);
    }

    public function rules(): array
    {
        return [
            'id_type' => 'required|exists:types,id',
            'name' => 'required|min:3',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.min' => 'Inputan nama minimal 3 karakter ',
            'name.required' => 'Inputan nama jenis barang harus diisi ',
            'id_type.required' => 'Inputan id jenis barang harus diisi ',
            'id_type.exists' => 'Inputan id jenis barang tidak terdaftar ',
        ];
    }
}
