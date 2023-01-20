<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'User');
        $user = User::where('status', '!=', 0);
        if ($request->ajax()) {
            return DataTables::of($user)->addIndexColumn()
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
                                            <a href="'.route('user.option',['action' => 'detail', 'name' => Str::slug($row['name']), 'c' => encrypt($row['id'])]).'" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                <span class="m-nav__link-text">Detail</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="'.route('user.option',['action' => 'edit', 'name' => Str::slug($row['name']), 'c' => encrypt($row['id'])]).'" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-edit"></i>
                                                <span class="m-nav__link-text">Edit</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="javascript:void(0)" onclick="deleteData(' . $row['id'] . ')" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-delete"></i>
                                                <span class="m-nav__link-text">Hapus</span>
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
        return view('content.users.v_index');
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
            User::updateOrCreate(
                ['id' => $request->id],
                $data
            );
            return response()->json([
                'message' => 'User berhasil disimpan',
                'status' => true,
            ], 200);
        }

    }

    public function option()
    {
        if ($_GET['action'] == 'detail') {
            session()->put('title', 'Detail User');
            $user = User::find(decrypt($_GET['c']));
            // dd($user);
            return view('content.users.v_detail_user', compact('user'));
        } else if($_GET['action'] == 'create') {
            session()->put('title', 'Membuat User');
            return view('content.users.v_form_user');
        }else{
            session()->put('title', 'Mengedit User');
            $user = User::find(decrypt($_GET['c']));
            return view('content.users.v_form_user', compact('user'));
        }

    }

    public function detail(Request $request)
    {
        return response()->json(Supplier::find($request['id']));
    }

    public function delete(Request $request)
    {
        $user = Supplier::find($request->id);
        $user->update(array('status' => 0));
        return response()->json([
            'message' => 'Suplier berhasil dihapus',
            'status' => true,
        ], 200);
    }
}
