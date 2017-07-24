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
	// Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLink')->name('admin.password.email');
	// Route::get('/password/email', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	// Route::post('/passwords/reset', 'Auth\AdminResetPasswordController@reset');
	// Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::get('automobile/create', 'AutomobileController@index')->name('automobile.create');
Route::post('automobile/create', 'AutomobileController@store')->name('automobile.create.submit');
Route::get('automobile/{id}', 'AutomobileController@showAutomobileForm')->name('automobile.show');
Route::post('automobile/update{id}', 'AutomobileController@update')->name('automobile.update');
Route::post('automobile/delete{id}', 'AutomobileController@delete')->name('automobile.delete');

Route::get('operator/create', 'OperatorController@index')->name('operator.create');
Route::post('operator/create', 'OperatorController@store')->name('operator.create.submit');
Route::get('operator/{id}', 'OperatorController@showOperatorForm')->name('operator.show');
Route::post('operator/update{id}', 'OperatorController@update')->name('operator.update');
Route::post('operator/delete{id}', 'OperatorController@delete')->name('operator.delete');