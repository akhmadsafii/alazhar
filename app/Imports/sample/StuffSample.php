<?php

namespace App\Imports\sample;

use App\Models\Stuff;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;

class StuffSample implements ToModel, WithHeadingRow,  WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 10;
    }

    public function model(array $row)
    {
        $category = DB::table('categories')
            ->where('id', $row['id_category'])
            ->where('status', '!=', 0)
            ->first();

        $stuff = Stuff::updateOrCreate(
            [
                'code' => Str::slug($row['name'])
            ],
            [
                'id_unit' => $row['id_unit'],
                'id_type' => $category->id_type,
                'id_category' => $row['id_category'],
                'id_supplier' => $row['id_supplier'],
                'name' => $row['name'],
                'price' => $row['price'],
                'amount' => $row['amount'],
                'status_bhp' => $row['status_bhp'],
                'status' => 1,
            ]
        );
    }

    public function rules(): array
    {

        return [
            'code' => 'unique:stuffs,id,NULL,id',
            'id_category' => 'required|exists:categories,id',
            'name' => 'required',
            'id_unit' => 'required|exists:units,id',
            'id_supplier' => 'nullable|exists:suppliers,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code.unique' => 'Inputan kode sudah terdaftar di database ',
            'id_category.required' => 'Inputan id kategori harus diisi ',
            'id_category.exists' => 'Inputan id kategori tidak terdaftar pada sekolah ',
            'name.required' => 'Inputan nama barang harus diisi ',
            'id_unit.required' => 'Inputan id satuan harus diisi ',
            'id_unit.exists' => 'Inputan id satuan tidak terdaftar pada sekolah ',
            // 'id_suplayer.required' => 'Inputan id suplayer barang harus diisi ',
            'id_supplier.exists' => 'Inputan id suplayer tidak terdaftar di sekolah ',
        ];
    }
}
