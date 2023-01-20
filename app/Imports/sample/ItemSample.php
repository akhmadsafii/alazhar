<?php

namespace App\Imports\sample;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ItemSample implements ToModel, WithHeadingRow,  WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 12;
    }

    public function model(array $row)
    {
        Item::create([
            'name' => $row['code'].'-'.$row['order_number'],
            'id_stuff' => $row['id_stuff'],
            'condition' => $row['condition'],
            'id_location' => $row['id_location'],
            'updated_date' => $row['updated_date'],
            'status' => 1
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:items,id,NULL,id',
            'id_stuff' => 'required|exists:stuffs,id',
            'order_number' => 'required',
            'condition' => 'required',
            'id_location' => 'required|exists:locations,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code.required' => 'Inputan kode harus diisi ',
            'code.unique' => 'Inputan kode sudah terdaftar ',
            'order_number.required' => 'Inputan urutan harus diisi ',
            'condition.required' => 'Inputan kondisi harus diisi ',
            'id_stuff.required' => 'Inputan id barang harus diisi ',
            'id_stuff.exists' => 'Inputan id barang tidak terdaftar di sekolah ',
            'id_location.required' => 'Inputan id ruang harus diisi ',
            'id_location.exists' => 'Inputan id ruang tidak terdaftar di sekolah ',
        ];
    }
}
