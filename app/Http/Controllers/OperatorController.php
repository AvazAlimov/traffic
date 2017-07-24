<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Operator;

class OperatorController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		return view('operator.operator-create');
	}

	public function store(Request $request)
	{
		//Validate the form
		$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required',
    		'password' => 'required'
		]);

		//set a Model
		$operator = new Operator;
		$operator->name = $request->name;
		$operator->email = $request->email;
		$operator->password = bcrypt($request->password);
		$operator->save();

		return redirect()->intended(route('admin.dashboard'));
	}

	public function showOperatorForm($id)
	{
		$operator = Operator::find($id);
		return view('operator.operator-update')->with('operator', $operator);
	}

	public function update(Request $request, $id)
	{
		//Validate the form
		$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required',
    		'password' => 'required'
		]);

		//set a Model
		$operator = Operator::find($id);
		$operator->name = $request->name;
		$operator->email = $request->email;
		$operator->password = bcrypt($request->password);
		$operator->save();

		return redirect()->intended(route('admin.dashboard'));
	}

	public function delete($id)
	{
		$operator = Operator::find($id);
		$operator->delete();
		return redirect()->intended(route('admin.dashboard'));
	}
}
