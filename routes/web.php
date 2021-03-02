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
Route::group(['namespace' => 'Api'], function() {
	Route::group(['middleware' => ['auth']], function() {
		//Route::get('provider-create','ProviderController@create')->name('provider.create');
		//Route::post('provider-store','ProviderController@store');
		Route::resource('providers','ProviderController');
		Route::resource('videodata','VideoController');
		Route::resource('photos','ImageController');
	});
});


Route::get('/home', 'HomeController@index')->name('home');
