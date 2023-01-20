<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function admin()
    {
        if($_GET['information'] == 'detail'){
            return view('content.profiles.admin.v_information');
        }else if($_GET['information'] == 'edit'){
            return view('content.profiles.admin.v_edit');
        }else if($_GET['information'] == 'reset-password'){
            return view('content.profiles.admin.v_reset_password');
        }else{
            return view('content.profiles.admin.v_close_account');
        }
    }

    public function update_profile(Request $request)
    {
        $customAttributes = [
            'name' => 'Nama',
            'email' => 'Email',
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
            session()->flash('response', [
                'class' => 'danger',
                'message' => $validator->messages()->first()
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = $request->toArray();
            if (!empty($request->file)) {
                $data = UploadHelper::upload_image($request, $data, 'file');
            }
            Admin::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            session()->flash('response', [
                'class' => 'success',
                'message' => 'Profil Berhasil diperbarui',
            ]);
            return redirect()->back();
        }
    }

    public function update_password(Request $request)
    {
        $customAttributes = [
            'current_password' => 'Password Baru',
            'confirm_password' => 'Password Konfirmasi',
        ];
        $rules = [
            'password' => ['required'],
            'current_password' => ['required'],
            'confirm_password' => ['required'],
        ];

        $messages = [
            'required' => ':attribute harus diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'status' => false,
            ], 302);
        } else {
            if (Auth::guard('admin')->check()) {
                $attempts = !Hash::check($request->password, Auth::guard('admin')->user()->password);
            } elseif (Auth::guard('user')->check()) {
                $attempts = !Hash::check($request->password, Auth::guard('user')->user()->password);
            }
            if ($attempts) {
                return response()->json([
                    'message' => 'Maaf, Password yang anda inputkan tidak cocok dengan password anda saat ini',
                    'status' => false,
                ], 200);
            } else {
                if ($request->current_password == $request->confirm_password) {
                    if (Auth::guard('admin')->check()) {
                        Admin::where('id', Auth::guard('admin')->user()->id)->update(array('password' => Hash::make($request->confirm_password)));
                    } elseif (Auth::guard('user')->check()) {
                        Admin::where('id', Auth::guard('user')->user()->id)->update(array('password' => Hash::make($request->confirm_password)));
                    }
                    return response()->json([
                        'message' => 'Password berhasil diperbarui',
                        'status' => true,
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Password baru anda tidak sama dengan konfirmasi password',
                        'status' => false,
                    ], 200);
                }
            }
        }
    }

    public function user(){
        // dd('user');
        session()->put('title', 'Profil Saya');
        if($_GET['information'] == 'detail'){
            return view('content.profiles.user.v_information');
        }else if($_GET['information'] == 'edit'){
            return view('content.profiles.user.v_edit');
        }else if($_GET['information'] == 'reset-password'){
            return view('content.profiles.user.v_reset_password');
        }else{
            return view('content.profiles.user.v_close_account');
        }
    }

    public function update_user(Request $request)
    {
        $customAttributes = [
            'name' => 'Nama',
            'email' => 'Email',
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
            session()->flash('response', [
                'class' => 'danger',
                'message' => $validator->messages()->first()
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = $request->toArray();
            if (!empty($request->file)) {
                $data = UploadHelper::upload_image($request, $data, 'file');
            }
            User::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            session()->flash('response', [
                'class' => 'success',
                'message' => 'Profil Berhasil diperbarui',
            ]);
            return redirect()->back();
        }
    }
}
