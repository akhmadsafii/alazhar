<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stuff;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class BarcodeController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Barcode');
        $category = Category::where('status', '!=', 0)->get();
        $type = Type::where('status', '!=', 0)->get();
        $unit = Unit::where('status', '!=', 0)->get();
        $supplier = Supplier::where('status', '!=', 0)->get();
        $stuff = Stuff::select(['stuffs.*'])->where('stuffs.status', '!=', 0)->with(['types', 'categories', 'items']);
        if ($request->ajax()) {
            return DataTables::of($stuff)->addIndexColumn()
                ->addColumn('action', function ($stuff) {
                    $item = $stuff->items;
                    $item = $item->where('status', '!=', 0);
                    $items = count($item);
                    if ($items > 0) {
                        $btn = '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(0)" onclick="printData(' . $stuff['id'] . ')"><i class="la la-qrcode"></i> Cetak QR</a>
                    </div>
                </span>';
                    } else {
                        $btn = '<small class="text-danger">Item Kosong</small>';
                    }
                    return $btn;
                })
                ->addColumn('total_items', function ($barcode) {
                    $item = $barcode->items;
                    $item = $item->where('status', '!=', 0);
                    return count($item);
                })
                ->rawColumns(['action', 'total_items'])
                ->make(true);
        }
        return view('content.barcodes.v_index', compact('category', 'type', 'unit', 'supplier'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $stuff = Stuff::where('id', $request->id)->with(['items'])->first();
        $layout = [
            'horizontal' => $request->amount_horizontal,
            'total' => $request->total_per_page
        ];
        // return view('content.barcodes.v_print_page', compact("stuff"));
        $pdf = PDF::loadView('content.barcodes.v_print_page', compact("stuff", "layout"));
        return $pdf->stream('barcode_sarana.pdf');
    }

    public function print()
    {
        // dd('print barcode');
        $stuff = Stuff::where('id', decrypt($_GET['k']))->with(['categories', 'types', 'items', 'items.locations'])->first();
        // dd($stuff);
        // return view('content.barcodes.v_print_page', compact("stuff"));
        $pdf = PDF::loadView('content.barcodes.v_print_page', compact("stuff"));
        return $pdf->stream('barcode_sarana.pdf');
    }
}
