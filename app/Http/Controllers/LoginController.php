<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class LoginController extends Controller
{
    public function loginPost(Request $request) {
        if ($request->post('email') || $request->post('password')) {
            $userdata = array(
                'email' => $request->post('email'),
                'password' => $request->post('password')
            );

            if (Auth::guard('web')->attempt($userdata)) {
                $user = User::where('email', $userdata['email'])->first();
                if($user)
                {
                    $request->session()->put('admin_id', $user->id);
                    // $request->session()->put('admin_role', $user->role);
                    $request->session()->put('admin_name', $user->name);
                    User::where('id',$user->id)->update(['last_active'=>date('Y-m-d H:i')]);
                    return redirect('/admin/home');
                }else
                {
                    return redirect('/login')->with(['error'=>'error']);
                }

            }
            return redirect('/login')->with(['error'=>'error']);
        }
    }
    public function logout() {
        Auth::guard('web')->logout();
        \Session::flush();
        return redirect('/login');
    }
}
