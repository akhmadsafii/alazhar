<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Helpers\StatusHelper;
use App\Helpers\UploadHelper;
use App\Models\Extermination;
use App\Models\Item;
use App\Models\Location;
use App\Models\Stuff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ExterminateController extends Controller
{
    public function index(Request $request)
    {
        // dd("tes");
        session()->put('title', 'Pemusnahan Barang');
        $stuff = Stuff::where([
            ['status_bhp', 0],
            ['status', '!=', 0]
        ])->get();
        // dd($stuff);
        $location = Location::where('status', '!=', 0)->get();
        // dd($location);
        $extermination = Extermination::join('items', 'items.id', '=', 'exterminations.id_item')
            ->join('stuffs', 'stuffs.id', '=', 'items.id_stuff')
            ->join('types', 'types.id', '=', 'stuffs.id_type')
            ->select(['exterminations.*', 'items.code as code_item', 'stuffs.name as name', 'types.group as type'])
            ->where('exterminations.status', '!=', 0);
        if ($_GET['status'] == 'submission')
            $extermination->where('exterminations.status', '=', 2);
        if ($_GET['status'] == 'approved')
            $extermination->where([
                ['exterminations.status', 1],
                ['exterminations.exterminated_date', NULL]
            ]);
        if ($_GET['status'] == 'rejected')
            $extermination->where('exterminations.status', '=', 3);
        if ($_GET['status'] == 'finished')
            $extermination->where([
                ['exterminations.status', 1],
                ['exterminations.exterminated_date', '!=', NULL]
            ]);
        if ($_GET['status'] == 'all-procurement')
            $extermination->where('exterminations.status', '!=', 0);

        // $extermination = $extermination->get();
        // dd($extermination);
        if ($request->ajax()) {
            // dd($request);
            return DataTables::of($extermination)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =  '<span class="dropdown">
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                            <i class="la la-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">';
                    if ($row['status'] == 1 && $row['exterminated_date'] == NULL) {
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="confirmData(' . $row['id'] . ')"><i class="la la-check-circle"></i> Konfirmasi</a>';
                    }
                    $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')"><i class="la la-info-circle"></i> Detail</a>';
                    if ($row['status'] == 2) {
                        $btn .= '<a class="dropdown-item" href="javascript:void(0)" onclick="editData(' . $row['id'] . ')"><i class="la la-edit"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')"><i class="la la-trash"></i> Hapus</a>';
                    }
                    $btn .= '</div></span>';
                    return $btn;
                })
                ->addColumn('stuff', function ($exterminate) {
                    return $exterminate['name'] != null ? $exterminate['name'] : '-';
                })
                ->editColumn('status', function ($exterminate) {
                    if ($exterminate['exterminated_date'] != NULL) {
                        return '<span class="m-badge m-badge--primary m-badge--wide">Selesai</span>';
                    } else {
                        return '<span class="m-badge m-badge--' . StatusHelper::exterminate($exterminate['status'])['class'] . ' m-badge--wide">' . StatusHelper::exterminate($exterminate['status'])['message'] . '</span>';
                    }
                })
                ->editColumn('date_extermination', function ($exterminate) {
                    return DateHelper::getHoursMinute($exterminate['extermination_date']);
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('group')) {
                        $instance->where('types.group', $request->get('group'));
                    }
                })
                ->rawColumns(['action', 'stuff', 'status', 'date_extermination'])
                ->make(true);
        }
        // dd($type);
        // dd('hallo');
        return view('content.exterminations.v_index', compact('stuff', 'location'));
    }

    public function store(Request $request)
    {
        $data = [];
        $file = [
            'file' => null
        ];
        if (!empty($request->file)) {
            $file = UploadHelper::upload_image($request, $data, 'file');
        }
        $id_stuff = $request->id_stuff;
        foreach ($request->item as $item) {
            if (!$request->id_stuff) {
                $d_item = Item::find($item);
                $id_stuff = $d_item->id_stuff;
            }
            $data[] = [
                'id_stuff' => $id_stuff,
                'id_item' => $item,
                'description' => $request->description,
                'file' => $file['file'],
                'extermination_date' => $request->extermination_date,
            ];
        }
        Extermination::insert($data);
        return response()->json([
            'message' => 'Pemusnahan Barang berhasil disimpan',
            'status' => true,
        ], 200);
    }

    public function update(Request $request)
    {
        // dd($request);
        $customAttributes = [
            'id_item' => 'Item Barang',
            'extermination_date' => 'Tanggal Pemusnahan',
        ];

        $max_size = 'max:' . env('SETTING_MAX_UPLOAD_IMAGE');
        $mimes = 'mimes:' . str_replace('|', ',', env('SETTING_FORMAT_IMAGE'));
        $rules = [
            'file' => ['image', $mimes, $max_size],
            'id_item' => ['required'],
            'extermination_date' => ['required'],
        ];

        $messages = [
            'required' => ':attribute harus diisi.',
            'mimes' => 'Format tipe gambar :attribute yang diupload tidak diperbolehkan',
            'max' => 'Ukuran maksimal file ' . env('SETTING_MAX_UPLOAD_IMAGE') / 1000 . ' MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'status' => false,
            ], 302);
        } else {
            $data = $request->toArray();
            if (!empty($request->file)) {
                $data = UploadHelper::upload_image($request, $data, 'file');
            }
            Extermination::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            return response()->json([
                'message' => 'Pemusnahan berhasil disimpan',
                'status' => true,
            ], 200);
        }
    }

    public function detail(Request $request)
    {
        $exterminate = Extermination::find($request['id']);
        $exterminate['show_file'] = $exterminate->file != null ? UploadHelper::show_image($exterminate->file) : 'https://via.placeholder.com/150';
        return response()->json($exterminate);
    }

    public function detail_complete(Request $request)
    {
        $exterminate = Extermination::where('id', $request['id'])->with(['stuffs', 'items'])->first();
        // dd($exterminate);
        $exterminate['extermination_date'] = DateHelper::getHoursMinute($exterminate->extermination_date);
        $exterminate['code_status'] = StatusHelper::exterminate($exterminate->status)['message'];
        $exterminate['show_file'] = $exterminate->file != null ? UploadHelper::show_image($exterminate->file) : 'https://via.placeholder.com/150';
        return response()->json($exterminate);
    }

    public function delete(Request $request)
    {
        $extermination = Extermination::find($request->id);
        $extermination->update(array('status' => 0));
        return response()->json([
            'message' => 'Pemusnahan Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function confirm(Request $request)
    {
        $extermination = Extermination::find($request->id);
        $extermination->update(array('exterminated_date' => now()));
        $stuff = Stuff::find($extermination->id_stuff);
        $return_amount = $stuff->amount - 1;
        $stuff->update(['amount' => $return_amount]);
        Item::where('id', $extermination->id_item)->update(['status' => 0]);
        return response()->json([
            'message' => 'Pemusnahan Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function update_status(Request $request)
    {
        $exterminate = Extermination::find($request->id);
        $exterminate->update(['status' => $request->status]);
        return response()->json([
            'message' => 'Status Peminjaman berhasil diupdate',
            'status' => true,
        ], 200);
    }
}
