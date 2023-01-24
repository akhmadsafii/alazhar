<?php

namespace App\Http\Controllers;

use App\Exports\StuffExample;
use App\Helpers\GeneralHelper;
use App\Imports\sample\StuffSample;
use App\Imports\StuffImport;
use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use App\Models\Procurement;
use App\Models\Source;
use App\Models\Stuff;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StuffController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Barang');
        $category = Category::where('status', '!=', 0)->get();
        $type = Type::where('status', '!=', 0)->get();
        $unit = Unit::where('status', '!=', 0)->get();
        $supplier = Supplier::where('status', '!=', 0)->get();
        $sources = Source::where('status', '!=', 0)->get();
        $stuff = Stuff::select(['stuffs.*'])->where('stuffs.status', '!=', 0)->with('types', 'categories')->get();
        if ($request->ajax()) {
            return DataTables::of($stuff)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if ($row['status_bhp'] == 1) {
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')"><i class="la la-info-circle"></i> Detail</a>';
                    } else {
                        $btn .= '<a class="dropdown-item" href="' . route('stuff.information', ['name' => $row['code']]) . '"><i class="la la-info-circle"></i> Detail</a>';
                    }
                    $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>
                        </div>
                    </span>';
                    return $btn;
                })
                ->editColumn('status_bhp', function ($stuff) {
                    if ($stuff['status_bhp'] == 1) {
                        $status_bhp = '<span class="m-badge m-badge--danger m-badge--wide">Habis Pakai</span>';
                    } else {
                        $status_bhp = '<span class="m-badge m-badge--info m-badge--wide">Tidak Habis Pakai</span>';
                    }
                    return $status_bhp;
                })
                ->addColumn('filter', function ($stuff) {
                    $text = 'filter sarana';
                    if ($stuff->types->group == 'prasarana') {
                        $text = 'filter prasarana';
                    }
                    return $text;
                })
                ->rawColumns(['action', 'status_bhp', 'filter'])
                ->make(true);
        }
        // dd($type);
        $import = array(
            'template' => route('stuff.template'),
            'upload' => route('stuff.import')
        );
        return view('content.stuffs.v_index', compact('category', 'type', 'unit', 'supplier', 'import', 'sources'));
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'id_category' => $request->id_category,
            'id_type' => $request->id_type,
            'id_supplier' => $request->id_supplier,
            'id_unit' => $request->id_unit,
            'amount' => $request->amount,
            'price' => $request->price ? str_replace('.', '', $request->price) : null
        ];
        if (!$request->id) {
            $category = Category::find($request['id_category']);
            $code_stuff = GeneralHelper::codeInitial($request->name);
            $code = $category['code'] . '-' . $code_stuff;
            $cek_stuff = Stuff::where('code', 'like', "$code%")->orderBy('id', 'asc')->get()->last();
            if ($cek_stuff == null) {
                $data['code'] = $code . ".1";
            } else {
                $code_st = explode('.', $cek_stuff->code);
                $getnumber = end($code_st);
                $start = $getnumber + 1;
                $data['code'] = $code . '.' . $start;
            }
        } else {
            if ($request->price) {
                Item::where('id_stuff', $request->id)->update(['price' => str_replace('.', '', $request->price)]);
            }
        }
        if ($request->bhp) {
            $status_bhp = 1;
        } else {
            $status_bhp = 0;
        }
        $data['status_bhp'] = $status_bhp;
        $stuff = Stuff::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        if ($status_bhp == 0 && !$request->id) {
            $source = Source::find($request->id_source);
            $code = $stuff['code'] . '-' . $source['code'];
            $item = Item::where('code', 'like', "$code%")->orderBy('id', 'asc')->get()->last();
            if ($item == null) {
                $data_item = [];
                for ($i = 1; $i <= $request->amount; $i++) {
                    $data_item[] = [
                        'id_stuff' => $stuff->id,
                        'code' => $code . '.' . $i,
                        'condition' => 'good',
                        'price' => $request->price ? str_replace('.', '', $request->price) : null,
                        'created_at' => now()
                    ];
                }
                Item::insert($data_item);
            } else {
                $code_base = explode('.', $item->code);
                $getnumber = end($code_base);
                $start = $getnumber + 1;
                $finish = $getnumber + $request->amount;
                $data_item = [];
                for ($i = $start; $i <= $finish; $i++) {
                    $data_item[] = [
                        'id_stuff' => $stuff->id,
                        'code' => $code . '.' . $i,
                        'condition' => 'good',
                        'price' => $request->price ? str_replace('.', '', $request->price) : null,
                        'created_at' => now()
                    ];
                }
                Item::insert($data_item);
            }
        }
        return response()->json([
            'message' => 'Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        $stuff = Stuff::where('id', $request['id'])->with('types', 'categories', 'units')->first();
        return response()->json($stuff);
    }

    public function delete(Request $request)
    {
        $stuff = Stuff::find($request->id);
        $stuff->update(array('status' => 0));
        return response()->json([
            'message' => 'Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function info(Request $request)
    {
        session()->put('title', 'Detail Item');
        $locations = Location::where('status', '!=', 0)->get();
        $sources = Source::where('status', '!=', 0)->get();
        $stuff = Stuff::where('code', $_GET['name'])->with('types', 'categories', 'units', 'activeItems', 'activeItems.locations')->first();
        // dd($stuff);
        if ($request->ajax()) {
            return DataTables::of($stuff->activeItems)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')"><i class="la la-info-circle"></i> Detail</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                    </div>
                </span>';
                })
                ->editColumn('condition', function ($item) {
                    return (($item->condition == 'good') ? "Baik" : "Rusak");
                })
                ->addColumn('location', function ($item) {
                    return $item->locations != null ? $item->locations->name : "Lokasi belum diset";
                })
                ->rawColumns(['action', 'location'])
                ->make(true);
        }
        return view('content.stuffs.v_information', compact('stuff', 'locations', 'sources'));
    }

    public function template()
    {
        return Excel::download(new StuffExample, '' . Carbon::now()->timestamp . '_template_barang_import.xls');
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
                $import = Excel::import(new StuffImport, $file);

                return response()->json([
                    'message' => 'barang imported',
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
