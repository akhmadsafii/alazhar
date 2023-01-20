<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Opname;
use App\Models\Stuff;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Stock Opname');
        $opname = Opname::where('id_stuff', 1)->get()->last();
        // dd($opname->id_stuff);
        $stuffs = Stuff::where([
            ['status_bhp', 1],
            ['status', '!=', 0]
        ])->get();
        $opnames = Opname::select(['opnames.*'])->where('status', '!=', 0)->with(['stuffs'])->orderBy('id', 'desc');
        if ($request->ajax()) {
            return DataTables::of($opnames)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $opname = Opname::where('id_stuff', $row['id_stuff'])->get()->last();
                    $id_opname = $opname->id;
                    $btn = '<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                    <a href="javascript:void(0)" class="m-portlet__nav-link m-dropdown__toggle btn m-btn m-btn--link">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="m-dropdown__wrapper" style="width: 120px">
                        <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner" style="width: 120px">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">';
                                    if ($id_opname == $row['id']) {
                                        $btn .= '<li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="editData('.$row['id'].')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-edit"></i>
                                                <span class="m-nav__link-text">Edit</span>
                                            </a>
                                        </li>';
                                    } else {
                                        $btn .= '<li class="m-nav__item text-center">
                                        <a class="m-nav__link">
                                            <small class="text-info">Data terakhir yang bisa diedit</small>
                                        </a>
                                    </li>';
                                    }
                                    $btn .= '</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                    return $btn;
                })
                ->editColumn('date_opname', function ($opname) {
                    return DateHelper::getTanggal($opname['date_opname']);
                })
                // ->editColumn('status', function ($rental) {
                //     return '<span class="m-badge m-badge--'.StatusHelper::consumables($rental['status'])['class'].' m-badge--wide">'.StatusHelper::consumables($rental['status'])['message'].'</span>';

                // })
                ->rawColumns(['action', 'date_opname'])
                ->make(true);
        }
        // dd($type);
        return view('content.opnames.v_index', compact('stuffs'));
    }

    public function store(Request $request)
    {
        // dd($request);
        if($request->id){
            $detail_opname = Opname::find($request->id);
        }
        $opname = Opname::updateOrCreate(
            ['id' => $request->id],
            $request->toArray()
        );
        // dd($opname);
        $stuff = Stuff::find($request->id_stuff);
        if($request->id){
            // dd($detail_opname->plus_amount);
            $total = $stuff->amount - $detail_opname->plus_amount + $request->plus_amount;
            // dd($total);
            $stuff->update(['amount' => $total]);
        }else{
            if($opname){
                $stuff->update(['amount' => $request->total]);
            }
        }

        return response()->json([
            'message' => 'Stock Opname berhasil disimpan',
            'status' => true,
        ], 200);

    }

    public function detail(Request $request)
    {
        $opname = Opname::find($request->id);
        return response()->json($opname);
    }
}
