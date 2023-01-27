<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Depreciation;
use App\Models\Item;
use App\Models\Location;
use App\Models\Stuff;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepreciationController extends Controller
{
    public function index(Request $request)
    {
        // dd("tes");
        session()->put('title', 'Penyusutan Barang');
        $stuff = Stuff::where('status', '!=', 0)->get();
        $location = Location::where('status', '!=', 0)->get();
        $depreciations = Depreciation::join('items', 'items.id', '=', 'depreciations.id_item')
            ->join('stuffs', 'stuffs.id', '=', 'items.id_stuff')
            ->join('types', 'types.id', '=', 'stuffs.id_type')
            ->select(['depreciations.*', 'items.code as code_item', 'stuffs.name as name', 'types.group as type']);
        // dd($depreciations);
        if ($request->ajax()) {
            // dd($request);
            return DataTables::of($depreciations)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $cek = Depreciation::where([
                        ['id_item', $row['id_item']],
                        ['status', 1]
                    ])->get()->last();
                    if ($row['id'] == $cek['id']) {
                        return '<span class="dropdown">
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                        </div>
                        </span>';
                    } else {
                        return '-';
                    }
                })
                ->editColumn('date', function ($depr) {
                    return $depr['date'] ? DateHelper::getTanggal($depr['date']) : '-';
                })
                ->editColumn('code_item', function ($depr) {
                    return '<a href="' . route('depreciation.history', ['code' => $depr['code_item']]) . '">' . $depr['code_item'] . '</a>';
                })
                ->editColumn('initial_price', function ($depr) {
                    return number_format($depr['initial_price'], 0, ',', '.');
                })
                ->editColumn('price', function ($depr) {
                    return number_format($depr['price'], 0, ',', '.');
                })
                ->editColumn('final_price', function ($depr) {
                    return number_format($depr['final_price'], 0, ',', '.');
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('group')) {
                        $instance->where('types.group', $request->get('group'));
                    }
                })
                ->rawColumns(['action', 'date', 'initial_price', 'price', 'final_price', 'code_item'])
                ->make(true);
        }
        return view('content.depreciations.v_index', compact('stuff', 'location'));
    }

    public function store(Request $request)
    {
        // $data = [];
        foreach ($request->item as $item) {
            $d_item = Item::find($item);

            $data = [
                'id_item' => $item,
                'date' => $request->date,
                'initial_price' => $d_item['price'],
                'price' => str_replace('.', '', $request->price),
                'final_price' => $d_item['price'] - str_replace('.', '', $request->price),
                'created_at' => now()
            ];
            $depreciation = Depreciation::create($data);
            $item = Item::find($depreciation['id_item']);
            $item->update(['price' => $depreciation['final_price']]);
        }

        return response()->json([
            'message' => 'Penyusutan Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function update(Request $request)
    {
        // dd($request);
        $data = [
            'initial_price' => str_replace('.', '', $request->initial_price),
            'price' => str_replace('.', '', $request->price),
            'final_price' => str_replace('.', '', $request->final_price),
            'id_item' => $request->id_item,
            'date' => $request->date,
        ];
        Depreciation::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        Item::where('id', $request->id_item)->update(['price' => str_replace('.', '', $request->final_price)]);
        return response()->json([
            'message' => 'Penyusutan berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        $depreciation = Depreciation::where('id', $request['id'])->with('items')->first();
        return response()->json($depreciation);
    }

    public function history()
    {
        session()->put('title', 'Riwayat Penyusutan Barang');
        $item = Item::where('code', $_GET['code'])->with(['stuffs', 'stuffs.categories', 'stuffs.types'])->first();
        $depreciation = Depreciation::where('id_item', $item['id'])->orderBy('id', 'DESC')->get();
        return view('content.depreciations.v_history', compact('item', 'depreciation'));
    }
}
