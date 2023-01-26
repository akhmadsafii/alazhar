<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\GeneralHelper;
use App\Helpers\StatusHelper;
use App\Http\Resources\ProcurementResource;
use App\Models\Item;
use App\Models\Procurement;
use App\Models\Stuff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProcurementController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Pengadaan Barang');
        if ($_GET['status'] == 'all-procurement') {
        } else {
        }
        $user = User::where('status', '!=', 0)->get();
        $stuff = Stuff::where('status', '!=', 0)->get();

        $procurement =  Procurement::join('stuffs as st', 'st.id', '=', 'procurements.id_stuff')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->select('procurements.*', 'st.name as name_stuff', 'tp.group as group');
        if ($_GET['status'] == 'submission')
            $procurement->where('procurements.status', '=', 2);

        if ($_GET['status'] == 'approved')
            $procurement->where('procurements.status', '=', 1);
        if ($_GET['status'] == 'rejected')
            $procurement->where('procurements.status', '=', 3);
        if ($_GET['status'] == 'all-procurement')
            $procurement->where('procurements.status', '!=', 0);

        $procurement = $procurement->get();
        if ($request->ajax()) {
            return DataTables::of($procurement)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')"><i class="la la-info-circle"></i> Detail</a>';
                    if ($row['status'] == 2) {
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>';
                    }
                    $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>
                        </div>
                    </span>';
                    return $btn;
                })
                ->editColumn('date_of_filing', function ($pro) {
                    return DateHelper::getTanggal($pro['date_of_filing']);
                })
                ->editColumn('date_received', function ($pro) {
                    return DateHelper::getTanggal($pro['date_received']);
                })
                ->editColumn('total_price', function ($pro) {
                    return number_format($pro['total_price'], 0, ',', '.');
                })
                ->editColumn('priority', function ($pro) {
                    if ($pro['status'] == 2) {
                        $class = 'warning';
                    } elseif ($pro['status'] == 3) {
                        $class = 'danger';
                    } else {
                        $class = 'success';
                    }
                    if ($pro['priority'] == 'urgent') {
                        $priority = '<span class="m-badge m-badge--danger m-badge--wide">Mendesak</span> / <span class="m--font-' . $class . '">' . StatusHelper::procurements($pro['status']) . '</span>';
                    } else {
                        $priority = '<span class="m-badge m-badge--info m-badge--wide">Normal</span> / <span class="m--font-' . $class . '">' . StatusHelper::procurements($pro['status']) . '</span>';
                    }
                    return $priority;
                })
                ->addColumn('filter', function ($procurement) {
                    $text = 'filter sarana';
                    if ($procurement['group'] == 'prasarana') {
                        $text = 'filter prasarana';
                    }
                    return $text;
                })
                ->rawColumns(['action', 'date_of_filing', 'date_received', 'priority', 'total_price', 'filter'])
                ->make(true);
        }
        // dd($type);
        return view('content.procurements.v_index', compact('stuff', 'user'));
    }
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->toArray();
        $unit_price = str_replace('.', '', $request->unit_price);
        $data['total_price'] = $request->amount * $unit_price;
        $data['status'] = 2;
        $data['unit_price'] = $unit_price;
        $result = Procurement::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        return response()->json([
            'message' => 'Pengadaan Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        $procurement = Procurement::where('id', $request['id'])->with('stuffs', 'users')->first();
        $procurement['format_unit_price'] = number_format($procurement['unit_price'], 0, ',', '.');
        $procurement['format_total_price'] = number_format($procurement['total_price'], 0, ',', '.');
        $procurement['format_date_of_filing'] = DateHelper::getTanggal($procurement['date_of_filing']);
        $procurement['format_date_received'] = DateHelper::getTanggal($procurement['date_received']);
        $procurement['code_handle'] = $procurement['code'] ?? '-';
        $procurement['code_status'] = StatusHelper::procurements($procurement['status']);
        return response()->json($procurement);
    }

    public function delete(Request $request)
    {
        $procurement = Procurement::find($request->id);
        $procurement->update(array('status' => 0));
        return response()->json([
            'message' => 'Pengadaan Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function update_status(Request $request)
    {
        $procurement = Procurement::find($request->id);
        $procurement->update([
            'status' => $request->status
        ]);
        if ($request->status == 1) {
            $stuff = Stuff::find($procurement->id_stuff);
            $amount = $stuff->amount + $procurement->amount;
            $stuff->update(['amount' => $amount]);
            if ($stuff->status_bhp != 1) {
                $code_item = $procurement->code ?? GeneralHelper::getInital($stuff->name);
                $item = Item::where('name', 'like', "%$code_item%")->orderBy('id', 'asc')->get()->last();
                if ($item == null) {
                    $data_item = [];
                    for ($i = 1; $i <= $procurement->amount; $i++) {
                        $data_item[] = [
                            'id_stuff' => $procurement->id_stuff,
                            'name' => $code_item . '-' . $i,
                            'condition' => 'good',
                            'created_at' => now(),
                        ];
                    }
                    Item::insert($data_item);
                } else {
                    $code = explode('-', $item->name);
                    $getnumber = end($code);
                    $start = $getnumber + 1;
                    $finish = $getnumber + $request->amount;
                    $data_item = [];
                    for ($i = $start; $i <= $finish; $i++) {
                        $data_item[] = [
                            'id_stuff' => $procurement->id_stuff,
                            'name' => $code_item . '-' . $i,
                            'condition' => 'good',
                            'created_at' => now(),
                        ];
                    }
                    Item::insert($data_item);
                }
            }
        }
        return response()->json([
            'message' => 'Status berhasil diupdate',
            'status' => true,
        ], 200);
    }

    public function list_procurement(Request $request)
    {
        session()->put('title', 'Pengadaan Barang');

        $stuff = Stuff::select(['stuffs.*'])->where('stuffs.status', '!=', 0)->with('types', 'categories')->get();
        // dd($stuff);
        if ($request->ajax()) {
            return DataTables::of($stuff)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('user.submission.procurement.detail', ['name' => $row['code']]) . '" class="btn btn-brand m-btn m-btn--custom">Lihat</a>';
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
        return view('content-users.submissions.procurements.v_procurement');
    }

    public function detail_rental(Request $request)
    {
        $stuff = Stuff::where('code', $_GET['name'])->with('types', 'categories')->first();
        return view('content-users.submissions.procurements.v_detail', compact('stuff'));
    }

    public function save_user(Request $request)
    {
        $data = $request->toArray();
        $unit_price = str_replace('.', '', $request->unit_price);
        $data['total_price'] = $request->amount * $unit_price;
        $data['date_of_filing'] = now();
        $data['status'] = 2;
        $data['id_user'] = Auth::guard('user')->id();
        $data['unit_price'] = $unit_price;
        Procurement::updateOrCreate(
            ['id' => $request->id],
            $data
        );
        return response()->json([
            'message' => 'Pengadaan Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }
}
