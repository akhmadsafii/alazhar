<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Admin');
        $admin = Admin::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($admin)->addIndexColumn()
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
                                                <span class="m-nav__link-text">Detail</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="editData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-edit"></i>
                                                <span class="m-nav__link-text">Edit</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.admins.v_index');
    }

    public function store(Request $request)
    {
        // dd($request);
        $customAttributes = [
            'name' => 'Nama User',
            'email' => 'Email User',
        ];

        $max_size = 'max:' . env('SETTING_MAX_UPLOAD_IMAGE');
        $mimes = 'mimes:' . str_replace('|', ',', env('SETTING_FORMAT_IMAGE'));
        $rules = [
            'file' => ['image', $mimes, $max_size],
            'name' => ['required', "regex:/^[a-zA-Z .,']+$/"],
            'email' => ['required'],
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
            if($request->password){
                $data['reset_password'] = $request->password;
            }
            Admin::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            return response()->json([
                'message' => 'Admin berhasil disimpan',
                'status' => true,
            ], 200);
        }

    }

    public function detail(Request $request)
    {
        $admin = Admin::find($request['id']);
        $admin['show_file'] = UploadHelper::show_image($admin['file']);
        return response()->json($admin);
    }

    public function delete(Request $request)
    {
        $admin = Admin::find($request->id);
        $admin->update(array('status' => 0));
        return response()->json([
            'message' => 'Suplier berhasil dihapus',
            'status' => true,
        ], 200);
    }
}
