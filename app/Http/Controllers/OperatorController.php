<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        return $this->middleware('auth:operator');
    }

    public function index()
    {
        return view('operator');
    }
}
