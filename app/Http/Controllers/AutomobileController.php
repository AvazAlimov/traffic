<?php

namespace App\Http\Controllers;
use App\Automobile;
use Illuminate\Http\Request;

class AutomobileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		return view('automobile.automobile-create');
	}

	public function store(Request $request)
	{
		//Validate the request
		$this->validate($request, [
    		'name' => 'required',
    		'price' => 'required',
    		'info' => 'required'
		]);

		//set a Model
		$automobile = new Automobile;
		$automobile->name = $request->name;
		$automobile->info = $request->info;
		$automobile->price = $request->price;
		$automobile->image = $request->image;
		$automobile->save();

		return redirect()->intended(route('admin.dashboard'));
	}

	public function showAutomobileForm($id)
	{
		$automobile = Automobile::find($id);
		return view('automobile.automobile-update')->with('automobile', $automobile);
	}

	public function update(Request $request, $id)
	{
		//Validate the request
		$this->validate($request, [
    		'name' => 'required',
    		'price' => 'required',
    		'info' => 'required'
		]);

		$automobile = Automobile::find($id);
		$automobile->name = $request->name;
		$automobile->info = $request->info;
		$automobile->price = $request->price;
		$automobile->image = $request->image;
		$automobile->save();

		return redirect()->intended(route('admin.dashboard'));
	}

	public function delete($id)
	{
		$automobile = Automobile::find($id);
		$automobile->delete();
		return redirect()->intended(route('admin.dashboard'));
	}
}