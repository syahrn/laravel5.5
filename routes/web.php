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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
		Route::view('/', 'dashboard');
		Route::view('/home', 'dashboard')->name('home');
		Route::resource('/user', 'UserController');
		Route::get('/data-user', 'UserController@data')->name('data-user');

	});