<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\StatusHelper;
use App\Models\Item;
use App\Models\Location;
use App\Models\Rental;
use App\Models\Stuff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Peminjaman Barang');
        $user = User::where('status', '!=', 0)->get();
        $stuff = Stuff::where([
            ['status_bhp', 0],
            ['status', '!=', 0]
        ])->get();
        $location = Location::where('status', '!=', 0)->get();

        $rental =  Rental::join('stuffs as st', 'st.id', '=', 'rentals.id_stuff')
            ->join('items as it', 'it.id', '=', 'rentals.id_item')
            ->join('users as us', 'us.id', '=', 'rentals.id_user')
            ->join('types as tp', 'tp.id', '=', 'st.id_type')
            ->select('rentals.*', 'st.name as name_stuff', 'it.code as name_item', 'us.name as name_user', 'tp.group as group');
        if ($_GET['status'] == 'submission')
            $rental->where('rentals.status', '=', 2);

        if ($_GET['status'] == 'approved')
            $rental->where([
                ['rentals.status', '=', 1],
                ['rentals.returned_date', NULL]
            ]);
        if ($_GET['status'] == 'rejected')
            $rental->where('rentals.status', '=', 3);
        if ($_GET['status'] == 'finished')
            $rental->where([
                ['rentals.status', '=', 1],
                ['rentals.returned_date', '!=', NULL]
            ]);
        if ($_GET['status'] == 'all-procurement')
            $rental->where('rentals.status', '!=', 0);

        $rental = $rental->get();
        if ($request->ajax()) {
            return DataTables::of($rental)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if ($row['returned_date'] == null && $row['status'] == 1) {
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="confirmBack(' . $row['id'] . ')"><i class="la la-check-circle"></i> Konfirmasi Kembali</a>';
                    }
                    $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')"><i class="la la-info-circle"></i> Detail</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>
                        </div>
                    </span>';
                    return $btn;
                })
                ->editColumn('rental_date', function ($row) {
                    return DateHelper::getHoursMinute($row['rental_date']);
                })
                ->editColumn('return_date', function ($row) {
                    return DateHelper::getHoursMinute($row['return_date']);
                })
                ->addColumn('filter', function ($rental) {
                    $text = 'filter sarana';
                    if ($rental['group'] == 'prasarana') {
                        $text = 'filter prasarana';
                    }
                    return $text;
                })
                ->rawColumns(['action', 'rental_date', 'return_date', 'filter'])
                ->make(true);
        }
        // dd($type);
        return view('content.rentals.v_index', compact('stuff', 'user', 'location'));
    }

    public function store(Request $request)
    {
        // dd($request);

        if ($request['item']) {
            $data = [];
            // dd($request->item);
            foreach ($request->item as $key => $value) {
                $data[] = [
                    'id_stuff' => $request->id_stuff,
                    'id_item' => $value,
                    'id_user' => $request->id_user,
                    'rental_date' => $request->rental_date,
                    'return_date' => $request->return_date,
                    'description' => $request->description,
                    'status' => $request->status,
                    'created_at' => now(),
                ];
            }
            // dd($data);
            Rental::insert($data);
            if ($request->status == 1) {
                Item::whereIn('id', $request->item)->update(['status' => 2]);
            }
            return response()->json([
                'message' => 'Pengadaan Barang berhasil disimpan',
                'status' => true,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Anda belum memasukan item barang',
                'status' => false,
            ], 400);
        }
    }

    public function update(Request $request)
    {
        // dd($request);
        Rental::updateOrCreate(
            ['id' => $request->id],
            $request->toArray()
        );
        return response()->json([
            'message' => 'Peminjaman berhasil diupdate',
            'status' => true,
        ], 200);
    }

    public function detail(Request $request)
    {
        return response()->json(Rental::find($request['id']));
    }

    public function detail_complete(Request $request)
    {
        $rental = Rental::where('id', $request->id)->with('users', 'stuffs')->get()->first();
        $rental['e_rental_date'] = $rental['rental_date'] == null ? '-' : DateHelper::getHoursMinute($rental['rental_date']);
        $rental['e_return_date'] = $rental['return_date'] == null ? '-' : DateHelper::getHoursMinute($rental['return_date']);
        if ($rental['returned_date'] == null) {
            $rental['status_rental'] = now() >= $rental['return_date'] ? 'terlambat' : 'berlangsung';
            $rental['e_returned_date'] = '-';
        } else {
            $rental['status_rental'] = $rental['returned_date'] >= $rental['return_date'] ? 'terlambat' : 'berlangsung';
            $rental['e_returned_date'] = DateHelper::getHoursMinute($rental['e_returned_date']);;
        }
        return response()->json($rental);
    }

    public function delete(Request $request)
    {
        $procurement = Rental::find($request->id);
        $procurement->update(array('status' => 0));
        return response()->json([
            'message' => 'Peminjaman Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function confirm_date(Request $request)
    {
        Rental::where('id', $request->id)->update(['returned_date' => $request->returned_date]);
        return response()->json([
            'message' => 'Peminjaman berhasil diupdate',
            'status' => true,
        ], 200);
    }

    public function data_item()
    {
        $rental = Rental::select(['rentals.*'])->where('rentals.status', '!=', 0)->with('users');

        $table = datatables()->of($rental)
            ->editColumn('role', function ($rental) {
                if ($rental->role == 'teacher') {
                    $role = 'Guru';
                } elseif ($rental->role == 'student') {
                    $role = 'Siswa';
                } elseif ($rental->role == 'staff') {
                    $role = 'Staff';
                } else {
                    $role = 'Lainnya';
                }
                return $role;
            })
            ->editColumn('rental_date', function ($rental) {
                return DateHelper::getHoursMinute($rental['rental_date']);
            })
            ->editColumn('return_date', function ($rental) {
                return DateHelper::getHoursMinute($rental['return_date']);
            })
            ->editColumn('status', function ($rental) {
                return '<span class="m-badge m-badge--' . StatusHelper::rentals($rental['status'])['class'] . ' m-badge--wide">' . StatusHelper::rentals($rental['status'])['message'] . '</span>';
            });
        $table->rawColumns(['rental_date', 'role', 'return_date', 'status']);
        $table->addIndexColumn();
        return $table->make(true);
    }

    public function update_status(Request $request)
    {
        Rental::where('id', $request->id)->update(['status' => $request->status]);
        return response()->json([
            'message' => 'Status Peminjaman berhasil diupdate',
            'status' => true,
        ], 200);
    }

    public function list_rental(Request $request)
    {
        session()->put('title', 'Peminjaman Barang');

        $stuff = Stuff::select(['stuffs.*'])->where([
            ['stuffs.status_bhp', 0],
            ['stuffs.status', '!=', 0]
        ])->with('types', 'categories')->get();
        // dd($stuff);
        if ($request->ajax()) {
            return DataTables::of($stuff)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('user.submission.rental.detail', ['name' => $row['code']]) . '" class="btn btn-brand m-btn m-btn--custom">Lihat</a>';
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
        return view('content-users.submissions.rentals.v_rental', compact('stuff'));
    }

    public function detail_rental(Request $request)
    {
        // dd('detail');
        $stuff = Stuff::where('code', $_GET['name'])->with('types', 'categories')->first();
        $items = Item::select(['items.*'])->where([
            ['items.id_stuff', $stuff->id],
            ['items.status', '!=', 0]
        ])->with('stuffs', 'locations');
        if ($request->ajax()) {
            return DataTables::of($items)->addIndexColumn()
                ->addColumn('checkbox', function ($item) {
                    return '<div class="m-checkbox-list">
                        <label class="m-checkbox">
                            <input type="checkbox" name="item[]" value="' . $item['id'] . '" class="check_items">&nbsp;
                            <span></span>
                        </label>
                    </div>';
                })
                ->editColumn('condition', function ($item) {
                    return (($item->condition == 'good') ? "Baik" : "Rusak");
                })
                ->addColumn('location', function ($item) {
                    return $item->locations != null ? $item->locations->name : "Lokasi belum diset";
                })
                ->rawColumns(['checkbox', 'condition', 'location'])
                ->make(true);
        }
        return view('content-users.submissions.rentals.v_detail', compact('stuff'));
    }

    public function save_user(Request $request)
    {
        if ($request['id_item']) {
            $data = [];
            foreach (explode(',', $request['id_item']) as $value) {
                $data[] = [
                    'id_stuff' => $request->id_stuff,
                    'id_item' => $value,
                    'id_user' => Auth::guard('user')->id(),
                    'rental_date' => $request->rental_date,
                    'return_date' => $request->return_date,
                    'description' => $request->description,
                    'status' => 2,
                ];
            }
            // dd($data);
            Rental::insert($data);
            return response()->json([
                'message' => 'Peminjaman Barang berhasil disimpan',
                'status' => true,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Anda belum memasukan item barang',
                'status' => false,
            ], 400);
        }
    }
}
