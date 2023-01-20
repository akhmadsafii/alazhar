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
        $extermination =  Extermination::select(['exterminations.*'])->with('stuffs', 'items', 'stuffs.types')->where('status', '!=', 0);
        // dd($extermination);
        if ($_GET['status'] == 'submission')
            $extermination->where('exterminations.status', '=', 2);
        if ($_GET['status'] == 'approved')
            $extermination->where('exterminations.status', '=', 1);
        if ($_GET['status'] == 'rejected')
            $extermination->where('exterminations.status', '=', 3);
        if ($_GET['status'] == 'all-procurement')
            $extermination->where('exterminations.status', '!=', 0);

        $extermination = $extermination->get();
        // dd($extermination);
        if ($request->ajax()) {
            return DataTables::of($extermination)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                    <a href="javascript:void(0)" class="m-portlet__nav-link m-dropdown__toggle btn m-btn m-btn--link">
                        <i class="la la-ellipsis-v"></i>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner" >
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="detailData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                <span class="m-nav__link-text">Detail</span>
                                            </a>
                                        </li>';
                    if ($row['status'] == 2) {
                        $btn .= '<li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="editData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-edit"></i>
                                                <span class="m-nav__link-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
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
                ->addColumn('stuff', function ($exterminate) {
                    return $exterminate->stuffs != null ? $exterminate->stuffs->name : '-';
                })
                ->editColumn('status', function ($exterminate) {
                    return '<span class="m-badge m-badge--' . StatusHelper::exterminate($exterminate['status'])['class'] . ' m-badge--wide">' . StatusHelper::exterminate($exterminate['status'])['message'] . '</span>';
                })
                ->addColumn('filter', function ($exterminate) {
                    $text = 'filter sarana';
                    if ($exterminate->stuffs->types->group == 'prasarana') {
                        $text = 'filter prasarana';
                    }
                    return $text;
                })
                ->rawColumns(['action', 'stuff', 'status', 'filter'])
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
        $procurement = Extermination::find($request->id);
        $procurement->update(array('status' => 0));
        return response()->json([
            'message' => 'Pemusnahan Barang berhasil dihapus',
            'status' => true,
        ], 200);
    }

    public function update_status(Request $request)
    {
        $exterminate = Extermination::find($request->id);
        $exterminate->update(['status' => $request->status]);
        if ($request->status == 1) {
            $stuff = Stuff::find($exterminate->id_stuff);
            $return_amount = $stuff->amount - 1;
            $stuff->update(['amount' => $return_amount]);
            Item::where('id', $exterminate->id_item)->update(['status' => 0]);
        }
        return response()->json([
            'message' => 'Status Peminjaman berhasil diupdate',
            'status' => true,
        ], 200);
    }
}
