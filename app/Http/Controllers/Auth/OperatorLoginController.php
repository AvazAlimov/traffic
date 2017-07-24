<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class OperatorLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:operator', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.operator-login');
    }

    public function login(Request $request)
    {
        //Validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        //Attempt to log the user in
        if(Auth::guard('operator')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember))
        {
            //if successful, then redirect to their intended location

            return redirect()->intended(route('operator.dashboard'));
        }

        //if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInputs($request->only('username', 'remember'));
    }

    public function logout()
    {
        Auth::guard('operator')->logout();
        return redirect('/');
    }
}