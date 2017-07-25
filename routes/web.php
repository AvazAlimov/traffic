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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('users/logout','Auth\LoginController@userLogout')->name('user.logout');
Route::prefix('admin')->group(function(){
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
});

Route::prefix('operator')->group(function(){
    Route::get('/login', 'Auth\OperatorLoginController@showLoginForm')->name('operator.login');
    Route::post('/login', 'Auth\OperatorLoginController@login')->name('operator.login.submit');
    Route::get('/', 'OperatorController@index')->name('operator.dashboard');
    Route::get('/logout', 'Auth\OperatorLoginController@logout')->name('operator.logout');

    Route::prefix('/order')->group(function (){
    Route::get('/create', 'OperatorController@createOrder')->name('operator.order.create');
    Route::post('/submit', 'OperatorController@orderSubmit')->name('operator.order.submit');
    });
});

Route::post('tarif/update{id}', 'AdminController@updateTarif')->name('tarif.update');
