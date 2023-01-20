<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\StatusHelper;
use App\Models\Consumable;
use App\Models\Stuff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ConsumableController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Penggunaan BHP');
        $stuff = Stuff::where([
            ['status_bhp', 1],
            ['status', '!=', 0]
        ])->get();
        $user = User::where('status', '!=', 0)->get();
        $consumable = Consumable::select(['consumables.*'])->where('consumables.status', '!=', 0)->with(['stuffs', 'users'])->orderBy('consumables.id', 'desc');
        if ($request->ajax()) {
            return DataTables::of($consumable)->addIndexColumn()
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
                                            <a href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                <span class="m-nav__link-text">Info</span>
                                            </a>
                                        </li>';
                    if ($row['status'] == 2) {
                        $btn .= '<li class="m-nav__item">
                                           <a href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')" class="m-nav__link">
                                               <i class="m-nav__link-icon flaticon-delete"></i>
                                               <span class="m-nav__link-text">Hapus</span>
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
                ->editColumn('request_date', function ($consumable) {
                    return DateHelper::getTanggal($consumable['requeset_date']);
                })
                ->editColumn('status', function ($rental) {
                    return '<span class="m-badge m-badge--' . StatusHelper::consumables($rental['status'])['class'] . ' m-badge--wide">' . StatusHelper::consumables($rental['status'])['message'] . '</span>';
                })
                ->rawColumns(['action', 'request_date', 'status'])
                ->make(true);
        }
        // dd($type);
        return view('content.consumables.v_index', compact('stuff', 'user'));
    }

    public function stock_bhp(Request $request)
    {
        session()->put('title', 'Barang Habis Pakai');
        $stuffs = Stuff::select(['stuffs.*'])->where([
            ['status_bhp', 1],
            ['status', '!=', 0]
        ])->get();
        if ($request->ajax()) {
            return DataTables::of($stuffs)->addIndexColumn()->make(true);
        }
        return view('content.consumables.v_stock');
    }

    public function store(Request $request)
    {
        // dd($request);
        Consumable::updateOrCreate(
            ['id' => $request->id],
            $request->toArray()
        );
        return response()->json([
            'message' => 'Penggunaan BHP berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        $consumable = Consumable::where('id', $request['id'])->with(['stuffs', 'users'])->first();
        $consumable['date'] = DateHelper::getTanggal($consumable['request_date']);
        return response()->json($consumable);
    }

    public function update_status(Request $request)
    {
        $consumable = Consumable::find($request->id);
        $consumable->update([
            'status' => $request->status
        ]);
        if ($request->status == 1) {
            $stuff = Stuff::find($consumable->id_stuff);
            $amount = $stuff->amount - $consumable->amount;
            $stuff->update(['amount' => $amount]);
        }
        return response()->json([
            'message' => 'Status berhasil diupdate',
            'status' => true,
        ], 200);
    }

    public function delete(Request $request)
    {
        $consumable = Consumable::find($request->id);
        $consumable->update(array('status' => 0));
        return response()->json([
            'message' => 'Penggunaan berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function data_stuff(Request $request)
    {
        // dd($request);
        $consumables = Consumable::select(['consumables.*'])->with('users', 'stuffs')->where([
            ['consumables.id_stuff', $request->id_stuff],
            ['consumables.status', '!=', 0]
        ])->orderBy('id', 'desc');

        $table = datatables()->of($consumables)
            ->editColumn('request_date', function ($consumable) {
                return DateHelper::getHoursMinute($consumable['request_date']);
            })
            ->editColumn('status', function ($rental) {
                return '<span class="m-badge m-badge--' . StatusHelper::rentals($rental['status'])['class'] . ' m-badge--wide">' . StatusHelper::rentals($rental['status'])['message'] . '</span>';
            });
        $table->rawColumns(['request_date', 'status']);
        $table->addIndexColumn();
        return $table->make(true);
    }

    public function list_consumable(Request $request)
    {
        session()->put('title', 'Pengadaan Barang');

        $stuff = Stuff::select(['stuffs.*'])->where([
            ['stuffs.status_bhp', 1],
            ['stuffs.status', '!=', 0]
        ])->with('types', 'categories')->get();
        // dd($stuff);
        if ($request->ajax()) {
            return DataTables::of($stuff)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('user.submission.consumable.detail', ['name' => $row['code']]) . '" class="btn btn-brand m-btn m-btn--custom">Lihat</a>';
                })
                ->editColumn('status_bhp', function ($stuff) {
                    if ($stuff['status_bhp'] == 1) {
                        $status_bhp = '<span class="m-badge m-badge--danger m-badge--wide">Habis Pakai</span>';
                    } else {
                        $status_bhp = '<span class="m-badge m-badge--info m-badge--wide">Tidak Habis Pakai</span>';
                    }
                    return $status_bhp;
                })
                ->rawColumns(['action', 'status_bhp'])
                ->make(true);
        }
        return view('content-users.submissions.consumables.v_procurement');
    }

    public function detail_consumable(Request $request)
    {
        $stuff = Stuff::where('code', $_GET['name'])->with('types', 'categories')->first();
        return view('content-users.submissions.consumables.v_detail', compact('stuff'));
    }

    public function save_user(Request $request)
    {
        // dd($request);
        $data = $request->toArray();
        $data['status'] = 2;
        $data['id_user'] = Auth::guard('user')->id();
        Consumable::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        return response()->json([
            'message' => 'Pengajuan Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }
}
