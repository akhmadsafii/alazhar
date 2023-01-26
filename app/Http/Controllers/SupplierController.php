<?php

namespace App\Http\Controllers;

use App\Exports\SupplierExample;
use App\Helpers\UploadHelper;
use App\Imports\SupplierImport;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Penyedia');
        $supplier = Supplier::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($supplier)->addIndexColumn()
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
                ->editColumn('file', function ($supplier) {
                    if ($supplier['file'] != null) {
                        return '
                        <div class="m-widget4__img m-widget4__img--logo">
                            <img src="' . UploadHelper::show_image($supplier['file']) . '" alt="" height="80">
                        </div>';
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['action', 'file'])
                ->make(true);
        }
        $import = array(
            'template' => route('supplier.template'),
            'upload' => route('supplier.import')
        );
        return view('content.suppliers.v_index', compact('import'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $customAttributes = [
            'name' => 'Nama Supplier',
            'phone' => 'Telepon Supplier',
        ];

        $max_size = 'max:' . env('SETTING_MAX_UPLOAD_IMAGE');
        $mimes = 'mimes:' . str_replace('|', ',', env('SETTING_FORMAT_IMAGE'));
        $rules = [
            'file' => ['image', $mimes, $max_size],
            'name' => ['required', "regex:/^[a-zA-Z .,']+$/"],
            'phone' => ['required'],
        ];

        $messages = [
            'required' => ':attribute harus diisi.',
            'mimes' => 'Format tipe gambar :attribute yang diupload tidak diperbolehkan',
            'max' => 'Ukuran maksimal file ' . env('SETTING_MAX_UPLOAD_IMAGE') / 1000 . ' MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'status' => false,
            ], 302);
        } else {
            $data = $request->toArray();
            if (!empty($request->file)) {
                $data = UploadHelper::upload_image($request, $data, 'file');
            }
            Supplier::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            return response()->json([
                'message' => 'Supplier berhasil disimpan',
                'status' => true,
            ], 200);
        }
    }

    public function detail(Request $request)
    {
        $supplier = Supplier::find($request['id']);
        if ($supplier->file != null) {
            $supplier['show_image'] = UploadHelper::show_image($supplier->file);
        } else {
            $supplier['show_image'] = null;
        }
        return response()->json($supplier);
    }

    public function delete(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->update(array('status' => 0));
        return response()->json([
            'message' => 'Suplier berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function template()
    {
        return Excel::download(new SupplierExample, '' . Carbon::now()->timestamp . '_template_supllier_import.xls');
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
                $import = Excel::import(new SupplierImport, $file);

                return response()->json([
                    'message' => 'Suplayer barang imported',
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
