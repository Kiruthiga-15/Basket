<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('admin.adminprofile.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = AdminUser::where(
            'username',
            $request->username
        )->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            session([
                'admin_id' => $admin->adminid,
                'admin_username' => $admin->username
            ]);

            return redirect('/admin/dashboard');
        }

        return back()->with(
            'error',
            'Invalid Username or Password'
        );
    }

    public function logout()
    {
        session()->forget([
            'admin_id',
            'admin_username'
        ]);

        return redirect('/admin/login');
    }
}