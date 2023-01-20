<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExample;
use App\Helpers\GeneralHelper;
use App\Imports\CategoryImport;
use App\Models\Category;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        session()->put('title', 'Kategori Barang');
        $type = Type::where('status', '!=', 0)->get();
        $category = Category::where('status', '!=', 0)->with('types');
        if ($request->ajax()) {
            return DataTables::of($category)->addIndexColumn()
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
            'template' => route('category.template'),
            'upload' => route('category.import')
        );
        return view('content.categories.v_index', compact('type', 'import'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $data = $request->toArray();
        if (!$request->id) {
            $type = Type::find($request['id_type']);
            $code_category = GeneralHelper::codeInitial($request->name);
            $code = $type['code'] . '-' . $code_category;
            $category = Category::where('code', 'like', "$code%")->orderBy('id', 'asc')->get()->last();
            if ($category == null) {
                $data['code'] = $code . ".1";
            } else {
                $code_ctg = explode('.', $category->code);
                $getnumber = end($code_ctg);
                $start = $getnumber + 1;
                $data['code'] = $code . '.' . $start;
            }
        }
        Category::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        return response()->json([
            'message' => 'Kategori Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        return response()->json(Category::find($request['id']));
    }

    public function by_type(Request $request)
    {
        $category = Category::where([
            ['status', '!=', 0],
            ['id_type', $request->id],
        ])->get();
        return response()->json($category);
    }

    public function type_select(Request $request)
    {
        // dd($request);
        $category = Category::where('id_type', $request->id_type)->get();
        $output = '';
        foreach ($category as $ct) {
            $output .= '<option value="' . $ct['id'] . '" ' . (($ct['id'] == $request->id) ? 'selected="selected"' : "") . '>' . $ct['name'] . '</option>';
        }
        return response()->json($output);
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->update(array('status' => 0));
        return response()->json([
            'message' => 'Kategori Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function template()
    {
        return Excel::download(new CategoryExample(), '' . Carbon::now()->timestamp . '_template_kategori_import.xls');
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
                $import = Excel::import(new CategoryImport, $file);

                return response()->json([
                    'message' => 'Kategori barang imported',
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
