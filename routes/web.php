<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $tariffs = App\Tarif::all();
    $tariff = array();

    foreach ($tariffs as $tr) {
        if ($tr->type == 0)
            $tariff[$tr->id] = "Внутри города";
        else
            $tariff[$tr->id] = "За городом";
    }

    $cars = App\Automobile::all();
    $car = array();
    foreach ($cars as $key) {
        $car[$key->id] = $key->name;
    }

    return view('welcome')->withTarif($tariff)->withCar($car)->withTarifs($tariffs)->withCars($cars);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Route::post('user/order/submit', 'HomeController@orderSubmit')->name('user.order.submit');
Route::get('user/order/again{id}', 'HomeController@orderAgain')->name('user.order.again');
Route::post('/','WebController@orderSubmit')->name('order.submit');

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    Route::get('operator/create', 'AdminOperatorController@index')->name('operator.create');
    Route::post('operator/create', 'AdminOperatorController@store')->name('operator.create.submit');
    Route::get('operator/{id}', 'AdminOperatorController@showOperatorForm')->name('operator.show');
    Route::post('operator/update{id}', 'AdminOperatorController@update')->name('operator.update');
    Route::post('operator/delete{id}', 'AdminOperatorController@delete')->name('operator.delete');

    Route::get('automobile/create', 'AutomobileController@index')->name('automobile.create');
    Route::post('automobile/create', 'AutomobileController@store')->name('automobile.create.submit');
    Route::get('automobile/{id}', 'AutomobileController@showAutomobileForm')->name('automobile.show');
    Route::post('automobile/update{id}', 'AutomobileController@update')->name('automobile.update');
    Route::post('automobile/delete{id}', 'AutomobileController@delete')->name('automobile.delete');

    Route::get('order/excel', 'AdminController@orderToExcel')->name('admin.order.excel');

    Route::post('tarif/update{id}', 'AdminController@updateTarif')->name('tarif.update');
    Route::post('taxitarif/update{id}', 'AdminController@updateTaxiTarif')->name('taxitarif.update');
});

Route::prefix('operator')->group(function () {
    Route::get('/login', 'Auth\OperatorLoginController@showLoginForm')->name('operator.login');
    Route::post('/login', 'Auth\OperatorLoginController@login')->name('operator.login.submit');
    Route::get('/', 'OperatorController@index')->name('operator.dashboard');
    Route::get('/logout', 'Auth\OperatorLoginController@logout')->name('operator.logout');
    Route::get('/search/order','OperatorController@search')->name('operator.search');
    Route::get('/search/taxi','OperatorController@taxiSearch')->name('operator.taxi.search');

    Route::prefix('order')->group(function () {
        Route::post('/submit', 'OperatorController@orderSubmit')->name('operator.order.submit');
        Route::post('/accept/{order_id}/{operator_id}', 'OperatorController@orderAccept')->name('operator.order.accept');
        Route::post('/refuse/{order_id}/{operator_id}', 'OperatorController@orderRefuse')->name('operator.order.refuse');
        Route::post('/delete/{order_id}', 'OperatorController@orderDelete')->name('operator.order.delete');
        Route::post('/restore/{id}', 'OperatorController@orderRestore')->name('operator.order.restore');
        Route::get('/update/{id}/', 'OperatorController@orderUpdate')->name('operator.order.update');
        Route::post('/update/{id}', 'OperatorController@orderUpdateSubmit')->name('operator.order.update.submit');
    });

    Route::prefix('taxiorder')->group(function () {
        Route::post('/submit', 'OperatorController@taxiOrderSubmit')->name('operator.taxiorder.submit');
        Route::post('/accept/{taxi_order_id}/{operator_id}', 'OperatorController@taxiOrderAccept')->name('operator.taxiorder.accept');
        Route::post('/refuse/{taxi_order_id}/{operator_id}', 'OperatorController@taxiOrderRefuse')->name('operator.taxiorder.refuse');
        Route::post('/delete/{taxi_order_id}', 'OperatorController@taxiOrderDelete')->name('operator.taxiorder.delete');
        Route::post('/restore/{id}', 'OperatorController@taxiOrderRestore')->name('operator.taxiorder.restore');
        Route::get('/update/{id}/', 'OperatorController@taxiOrderUpdate')->name('operator.taxiorder.update');
        Route::post('/update/{id}', 'OperatorController@taxiOrderUpdateSubmit')->name('operator.taxiorder.update.submit');

    });

});

