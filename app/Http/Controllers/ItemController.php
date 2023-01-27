<?php

namespace App\Http\Controllers;

use App\Exports\ItemExample;
use App\Http\Resources\ItemResource;
use App\Imports\ItemImport;
use App\Models\Item;
use App\Models\Location;
use App\Models\Procurement;
use App\Models\Rental;
use App\Models\Source;
use App\Models\Stuff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use PDF;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Item');
        $stuff = Stuff::where('status', '!=', 0)->get();
        $sources = Source::where('status', '!=', 0)->get();
        $location = Location::where('status', '!=', 0)->get();
        if ($request->ajax()) {
            $item = Item::select(['items.*'])->where('items.status', '!=', 0)->with('stuffs', 'locations', 'stuffs.types', 'stuffs.categories', 'sources')->get();
            return Datatables::of($item)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')"><i class="la la-info-circle"></i> Detail</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>
                        <a class="dropdown-item" href="' . route('item.print_qr', ['code' => $row['code']]) . '" target="_blank"><i class="la la-qrcode"></i> Cetak QR</a>
                    </div>
                </span>';
                })
                ->editColumn('condition', function ($item) {
                    return (($item->condition == 'good') ? "Baik" : "Rusak");
                })
                ->addColumn('location', function ($item) {
                    return $item->locations != null ? $item->locations->name : "Lokasi belum diset";
                })
                ->addColumn('filter', function ($item) {
                    $text = 'filter sarana';
                    if ($item->stuffs->types->group == 'prasarana') {
                        $text = 'filter prasarana';
                    }
                    return $text;
                })
                ->rawColumns(['action', 'condition', 'location', 'filter'])
                ->make(true);
        }

        $import = array(
            'template' => route('item.template'),
            'upload' => route('item.import')
        );
        return view('content.items.v_index', compact('stuff', 'location', 'import', 'sources'));
    }

    public function store(Request $request)
    {
        // dd($request);
        if ($request->id) {
            $data = array(
                'id_stuff' => $request->id_stuff,
                'id_location' => $request->id_location,
                'condition' => $request->condition,
                'date_received' => $request->date_received,
                'id_source' => $request->id_source,
            );
            Item::where('id', $request->id)->update($data);
            return response()->json([
                'message' => 'Item berhasil disimpan',
                'status' => true,
            ], 200);
        } else {

            $stuff = Stuff::find($request->id_stuff);
            $source = Source::find($request->id_source);
            $code = $stuff['code'] . '-' . $source['code'];
            $item = Item::where('code', 'like', "$code%")->orderBy('id', 'asc')->get()->last();
            // dd($item);
            if ($item == null) {

                $data_item = [];
                for ($i = 1; $i <= $request->amount; $i++) {
                    $data_item[] = [
                        'id_stuff' => $request->id_stuff,
                        'code' => $code . '.' . $i,
                        'condition' => 'good',
                        'id_source' => $request->id_source,
                        'date_received' => $request->date_received,
                        'id_location' => $request->id_location,
                        'price' => $stuff->price ? str_replace('.', '', $stuff->price) : null,
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
                        'id_stuff' => $request->id_stuff,
                        'code' => $code . '.' . $i,
                        'condition' => 'good',
                        'id_source' => $request->id_source,
                        'id_location' => $request->id_location,
                        'price' => $stuff->price ? str_replace('.', '', $stuff->price) : null,
                        'created_at' => now()
                    ];
                }
                Item::insert($data_item);
            }
            return response()->json([
                'message' => 'Item berhasil disimpan',
                'status' => true,
            ], 200);
        }
    }

    public function detail(Request $request)
    {
        $item = Item::where('id', $request['id'])->with('stuffs', 'stuffs.categories', 'stuffs.types', 'locations', 'types')->first();
        // dd($item);
        $item['location'] = $item->locations != null ? $item->locations->name : '-';
        return response()->json($item);
    }

    public function stuff(Request $request)
    {
        $item = Item::where('id_stuff', $request->id_stuff)->get();
        return response()->json($item);
    }

    public function load_stuff(Request $request)
    {
        $item = Item::where('id_stuff', $request->id_stuff)->get();
        // dd($item);
        $output = '';
        foreach ($item as $it) {
            $output .= '<option value="' . $it['id'] . '" ' . (($it['id'] == $request->id_item) ? 'selected' : '') . '>' . $it['code'] . '</option>';
        }
        return $output;
    }

    public function delete(Request $request)
    {
        $item = Item::find($request->id);
        $item->update(array('status' => 0));
        return response()->json([
            'message' => 'Item Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function location_item(Request $request)
    {
        $items = Item::where([
            ['id_stuff', $request->id_stuff],
            ['id_location', $request->id_location],
            ['status', '!=', 0],
        ])->get();
        $item = [];
        if ($items) {
            foreach ($items as $it) {
                if ($this->check_rental($it['id']) == true) {
                    $item[] = array(
                        'id' => $it['id'],
                        'name' => $it['name'],
                    );
                }
            }
        }

        return response()->json($item);
    }

    function check_rental($item)
    {
        $cek_rental = Rental::where([
            ['id_item', $item],
            ['returned_date', null]
        ])
            ->whereIn('status', [1, 2])->first();
        if ($cek_rental) {
            if ($cek_rental['id_item'] == $item) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function location_stuff(Request $request)
    {
        // dd($request);
        $items = Item::select(['items.*'])->where('items.status', '!=', 0)->with('stuffs', 'locations');
        if ($request->id_stuff)
            $items = $items->where('items.id_stuff', $request->id_stuff);
        if ($request->id_location)
            $items = $items->where('items.id_location', $request->id_location);
        $table = datatables()->of($items)
            ->addColumn('checkbox', function ($item) {
                if ($item['status'] == 1) {
                    return '<div class="m-checkbox-list">
                <label class="m-checkbox">
                    <input type="checkbox" name="item[]" value="' . $item['id'] . '" class="check_items">&nbsp;
                    <span></span>
                </label>
            </div>';
                } else {
                    return '-';
                }
            });
        $table->addColumn('location', function ($item) {
            return $item->locations != null ? $item->locations->name : '-';
        });
        $table->addColumn('all_check', function ($item) {
            return '<div class="m-checkbox-list">
                <label class="m-checkbox">
                    <input type="checkbox" name="item[]" value="' . $item['id'] . '" class="check_items">&nbsp;
                    <span></span>
                </label>';
        });
        $table->editColumn('condition', function ($item) {
            if ($item['condition'] == 'broken') {
                return '<span class="m-badge m-badge--danger m-badge--wide">Rusak</span>';
            } else {
                return '<span class="m-badge m-badge--success m-badge--wide">Bagus</span>';
            }
        });
        $table->rawColumns(['checkbox', 'location', 'condition', 'all_check']);
        $table->addIndexColumn();
        return $table->make(true);
    }

    public function template()
    {
        return Excel::download(new ItemExample, '' . Carbon::now()->timestamp . '_template_item_import.xls');
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
                $import = Excel::import(new ItemImport, $file);

                return response()->json([
                    'message' => 'Item imported',
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

    public function print_qr()
    {
        // $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate('string'));
        return view('content.barcodes.v_qr');
        $pdf = PDF::loadView('content.barcodes.v_qr');
        return $pdf->stream();
    }
}
