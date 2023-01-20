<?php

namespace App\Http\Controllers;

use App\Exports\TypeExample;
use App\Helpers\GeneralHelper;
use App\Imports\TypeImport;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Jenis Barang');
        $type = Type::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($type)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                    <a href="javascript:void(0)" class="m-portlet__nav-link m-dropdown__toggle btn m-btn m-btn--link">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="m-dropdown__wrapper" style="width: 120px">
                        <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner" style="width: 120px">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="editData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-edit"></i>
                                                <span class="m-nav__link-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-delete"></i>
                                                <span class="m-nav__link-text">Hapus</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $import = array(
            'template' => route('type.template'),
            'upload' => route('type.import')
        );
        return view('content.types.v_index', compact('import'));
    }

    public function store(Request $request)
    {
        $data = $request->toArray();
        if (!$request->id) {
            $code_type = GeneralHelper::codeInitial($request->name);
            $type = Type::where('code', 'like', "$code_type%")->orderBy('id', 'asc')->get()->last();
            if ($type == null) {
                $data['code'] = $code_type . ".1";
            } else {
                $code = explode('.', $type->code);
                $getnumber = end($code);
                $start = $getnumber + 1;
                $data['code'] = $code_type . "." . $start;
            }
        }
        Type::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        return response()->json([
            'message' => 'Jenis Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        return response()->json(Type::find($request['id']));
    }

    public function delete(Request $request)
    {
        $type = Type::find($request->id);
        $type->update(array('status' => 0));
        return response()->json([
            'message' => 'Jenis Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function template()
    {
        return Excel::download(new TypeExample, '' . Carbon::now()->timestamp . '_template_tipe_import.xls');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $error_tampil = [];

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
            ], 302);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                $import = Excel::import(new TypeImport, $file);

                return response()->json([
                    'message' => 'Jenis barang sarana / prasarana berhasil di import',
                    'status' => true,
                    'data' => []
                ], 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    $error_tampil = '' . $failure->errors()[0] . 'pada baris ke-' . $failure->row() . '';
                }

                return response()->json([
                    'message' => $error_tampil
                ], 302);
            }
        }
    }
}
