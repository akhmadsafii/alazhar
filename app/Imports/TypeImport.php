<?php

namespace App\Imports;

use App\Helpers\GeneralHelper;
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
        $code_type = GeneralHelper::codeInitial($row['name']);
        $type = Type::where('code', 'like', "$code_type%")->orderBy('id', 'asc')->get()->last();
        if ($type == null) {
            $final_code = $code_type . ".1";
        } else {
            $code = explode('.', $type->code);
            $getnumber = end($code);
            $start = $getnumber + 1;
            $final_code = $code_type . "." . $start;
        }
        Type::create([
            'code' => $final_code,
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
