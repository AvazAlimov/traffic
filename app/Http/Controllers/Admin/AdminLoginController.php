<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        return $this->middleware('guest:admin');
    }
    public function showLogin(){
        return view('admin.login');
    }
    public function login(Request $request){
        if(Auth::guard('admin')->attempt(['login' => $request->login, 'password'=> $request->password],$request->remember)){
            return redirect()->intended(route('admin.dashboard'));
        }
        return  redirect()->back()->withInput($request->only('logins', 'remember'))->withErrors(['wrong-attempt' => 'Entered email or password were wrong']);

    }
}
