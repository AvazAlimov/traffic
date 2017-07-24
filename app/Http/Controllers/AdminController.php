<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $automobiles = DB::table('automobiles')->get();
        $operators = DB::table('operators')->get();
        return view('admin')->with('automobiles', $automobiles)->with('operators', $operators);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
