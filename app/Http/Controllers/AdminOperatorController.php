<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Operator;
use Illuminate\Support\Facades\File;

class AdminOperatorController extends Controller
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
    		'username' => 'required',
    		'password' => 'required',
            'image' => 'image|max:2048',
		]);

		//set a Model
		$operator = new Operator;
		$operator->name = $request->name;
		$operator->username = $request->username;
		$operator->password = bcrypt($request->password);
        if($request->file('image') != null) {
            $file = $request->file('image');
            $file_name = time().'.'.$file->getClientOriginalName();
            $location = public_path('operator/');
            $file->move($location, $file_name);
            $operator->image = $file_name;
        }
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
    		'username' => 'required',
    		'password' => 'required',
            'image' => 'image|max:2048',
		]);

		//set a Model
		$operator = Operator::find($id);
        $operator->username = $request->username;
        $operator->name = $request->name;
		$operator->password = bcrypt($request->password);

        if($request->file('image') != null) {
            if($operator->image != null)
            {
                $old_image = $operator->image;
                File::delete(public_path('operator/').$old_image);
            }
            $file = $request->file('image');
            $file_name = time().'.'.$file->getClientOriginalName();
            $location = public_path('operator/');
            $file->move($location, $file_name);
            $operator->image = $file_name;
        }

		$operator->save();

		return redirect()->intended(route('admin.dashboard'));
	}

	public function delete($id)
	{
		$operator = Operator::find($id);
        if($operator->image != null)
        {
            $old_image = $operator->image;
            File::delete(public_path('operator/').$old_image);
        }
		$operator->delete();
		return redirect()->intended(route('admin.dashboard'));
	}
}