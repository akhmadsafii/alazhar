<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('content.auth.v_login');
    }

    public function verify_login(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($this->check_credentials($request), $request->filled('remember'))) {
            return response()->json([
                'message' =>  'Login sebagai admin berhasil',
                'status' =>  true,
                'target_url' =>  route('admin.dashboard'),
            ]);
            // return redirect()->intended(route('admin.dashboard'));
        } else if (Auth::guard('user')->attempt($this->check_credentials($request), $request->filled('remember'))) {
            // return redirect()->intended(route('user.dashboard'));
            return response()->json([
                'message' =>  'Login sebagai Pengguna berhasil',
                'status' =>  true,
                'target_url' =>  route('user.dashboard'),
            ]);
        }

        return response()->json([
            'message' =>  'Anda tidak mempunyai akses untuk login',
            'status' =>  false,
            'target_url' =>  route('auth.login'),
        ]);
        // return redirect()->back()->withInput()->withErrors(['msg' => 'Anda tidak mempunyai akses untuk login']);
    }

    protected function check_credentials(Request $request)
    {
        if (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('username'), 'password' => $request->get('password'), 'status' => 1];
        }
        return ['phone' => $request->get('username'), 'password' => $request->get('password'), 'status' => 1];
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }

        return redirect()->route('auth.login');
    }
}
