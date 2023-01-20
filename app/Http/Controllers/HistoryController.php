<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\StatusHelper;
use App\Models\Consumable;
use App\Models\Procurement;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    public function rental(Request $request)
    {
        session()->put('title', 'Peminjaman Barang');
        $rentals = Rental::select(['rentals.*'])->where([
            ['rentals.id_user', Auth::guard('user')->id()],
            ['rentals.status', '!=', 0]
        ])->with(['stuffs'])->orderBy('rentals.id', 'desc');
        if ($request->ajax()) {
            return DataTables::of($rentals)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" onclick="detailData('.$row['id'].')" class="btn btn-outline-info m-btn btn-sm m-btn--icon m-btn--pill m-btn--air">
                        <span>
                            <i class="la la-info-circle"></i>
                            <span>Info</span>
                        </span>
                    </button>';
                    return $btn;
                })
                ->editColumn('rental_date', function ($rental) {
                    return DateHelper::getTanggal($rental['rental_date']);
                })
                ->editColumn('return_date', function ($rental) {
                    return DateHelper::getTanggal($rental['return_date']);
                })
                ->editColumn('status', function ($rental) {
                    return '<span class="m-badge m-badge--' . StatusHelper::consumables($rental['status'])['class'] . ' m-badge--wide">' . StatusHelper::consumables($rental['status'])['message'] . '</span>';
                })
                ->rawColumns(['action', 'rental_date', 'return_date', 'status'])
                ->make(true);
        }
        // dd($type);
        return view('content-users.histories.v_rental');
    }

    public function procurement(Request $request)
    {
        session()->put('title', 'Pengadaan Barang');
        $procurements = Procurement::select(['procurements.*'])->where([
            ['procurements.id_user', Auth::guard('user')->id()],
            ['procurements.status', '!=', 0]
        ])->with(['stuffs'])->orderBy('procurements.id', 'desc');
        if ($request->ajax()) {
            return DataTables::of($procurements)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" onclick="detailData('.$row['id'].')" class="btn btn-outline-info m-btn btn-sm m-btn--icon m-btn--pill m-btn--air">
                        <span>
                            <i class="la la-info-circle"></i>
                            <span>Info</span>
                        </span>
                    </button>';
                    return $btn;
                })
                ->editColumn('date_of_filling', function ($procurement) {
                    return DateHelper::getTanggal($procurement['date_of_filling']);
                })
                ->editColumn('unit_price', function ($procurement) {
                    return number_format($procurement['unit_price'], 0, ',', '.');
                })
                ->editColumn('total_price', function ($procurement) {
                    return number_format($procurement['total_price'], 0, ',', '.');
                })
                ->editColumn('priority', function ($procurement) {
                    $class = 'primary';
                    $desc = 'Normal';
                    if($procurement['priority'] == 'urgent'){
                        $class = 'danger';
                        $desc = 'Mendesak';
                    }
                    return '<span class="m-badge m-badge--'.$class.' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-'.$class.'">' . $desc . '</span>';
                })
                ->editColumn('status', function ($rental) {
                    return '<span class="m-badge m-badge--' . StatusHelper::consumables($rental['status'])['class'] . ' m-badge--wide">' . StatusHelper::consumables($rental['status'])['message'] . '</span>';
                })
                ->rawColumns(['action', 'date_of_filling', 'unit_price', 'total_price', 'status', 'priority'])
                ->make(true);
        }
        // dd($type);
        return view('content-users.histories.v_procurement');
    }

    public function consumable(Request $request)
    {
        session()->put('title', 'Barang Habis Pakai');
        $consumables = Consumable::select(['consumables.*'])->where([
            ['consumables.id_user', Auth::guard('user')->id()],
            ['consumables.status', '!=', 0]
        ])->with(['stuffs'])->orderBy('consumables.id', 'desc');
        if ($request->ajax()) {
            return DataTables::of($consumables)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" onclick="detailData('.$row['id'].')" class="btn btn-outline-info m-btn btn-sm m-btn--icon m-btn--pill m-btn--air">
                        <span>
                            <i class="la la-info-circle"></i>
                            <span>Info</span>
                        </span>
                    </button>';
                    return $btn;
                })
                ->editColumn('request_date', function ($rental) {
                    return DateHelper::getTanggal($rental['request_date']);
                })
                ->editColumn('status', function ($rental) {
                    return '<span class="m-badge m-badge--' . StatusHelper::consumables($rental['status'])['class'] . ' m-badge--wide">' . StatusHelper::consumables($rental['status'])['message'] . '</span>';
                })
                ->rawColumns(['action', 'request_date', 'status'])
                ->make(true);
        }
        // dd($type);
        return view('content-users.histories.v_consumable');
    }
}
