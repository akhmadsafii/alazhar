<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SourceController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Sumber Dana');
        $location = Source::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($location)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>
                    </div>
                </span>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($type);
        $import = array(
            'template' => route('location.template'),
            'upload' => route('location.import')
        );
        return view('content.sources.v_index', compact('import'));
    }

    public function store(Request $request)
    {
        $customAttributes = [
            'name' => 'Atas Nama',
            'code' => 'Kode',
        ];
        if ($request->id) {
            $source = Source::find($request->id);
            $rules = [
                'code' => ['required', 'alpha', 'max:5', 'min:2', 'unique:sources,code,' . $source->id],
                'name' => ['required'],
            ];
        } else {
            $rules = [
                'code' => ['required', 'alpha', 'max:5', 'min:2', 'unique:sources,code'],
                'name' => ['required'],
            ];
        }

        $messages = [
            'required' => ':attribute harus diisi.',
            'min' => 'Panjang minimal :attribute adalah :min digit',
            'max' => 'Panjang maksimal :attribute adalah :max digit',
            'alpha' => 'Inputan :attribute harus huruf tanpa spasi dan simbol',
            'unique' => ':attribute sudah pernah terdaftar',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'status' => false
            ], 302);
        } else {
            $data = $request->toArray();
            $data['code'] = strtoupper($request->code);
            Source::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            return response()->json([
                'message' => 'Sumber Dana berhasil disimpan',
                'status' => true,
            ], 200);
        }
    }

    public function detail(Request $request)
    {
        return response()->json(Source::find($request['id']));
    }

    public function delete(Request $request)
    {
        $source = Source::find($request->id);
        $source->update(array('status' => 0));
        return response()->json([
            'message' => 'Sumber Dana berhasil dihapus',
            'status' => true,
        ], 200);
    }
}
