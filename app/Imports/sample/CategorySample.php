<?php

namespace App\Imports\sample;

use App\Helpers\GeneralHelper;
use App\Models\Category;
use App\Models\Type;
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
        $type = Type::where('code', $row['code_type'])->first();
        $code_category = GeneralHelper::codeInitial($row['name']);
        $code = $type['code'] . '-' . $code_category;
        $category = Category::where('code', 'like', "$code%")->orderBy('id', 'asc')->get()->last();
        if ($category == null) {
            $final_code = $code . ".1";
        } else {
            $code_ctg = explode('.', $category->code);
            $getnumber = end($code_ctg);
            $start = $getnumber + 1;
            $final_code = $code . '.' . $start;
        }
        // dd($row);
        Category::create([
            'code' => $final_code,
            'id_type' => $type['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'status' => 1
        ]);
    }

    public function rules(): array
    {
        return [
            'code_type' => 'required|exists:types,code',
            'name' => 'required|min:3',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.min' => 'Inputan nama minimal 3 karakter ',
            'name.required' => 'Inputan nama jenis barang harus diisi ',
            'code_type.required' => 'Inputan Kode jenis barang harus diisi ',
            'code_type.exists' => 'Inputan Kode jenis barang tidak terdaftar ',
        ];
    }
}
