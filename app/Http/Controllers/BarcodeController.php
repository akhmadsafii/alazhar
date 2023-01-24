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
                                                    <a href="' . route('barcode.print', ['k' => encrypt($stuff['id'])]) . '" target="_blank" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-file-2"></i>
                                                        <span class="m-nav__link-text">Cetak</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
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
