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
Route::get('wer', function () {
    echo $hashed = Hash::make('123456');
});
Route::group(['middleware' => 'check.login'], function() {
    Route::get('index', 'IndexController@index');
    Route::get('loginout', 'UserController@loginout');
    Route::any('add', 'IndexController@add');
});
Route::any('logindo', 'UserController@login');
Route::get('login', 'UserController@show');
Route::get('shop', 'GoodsController@shop');
Route::get('goodscate', 'GoodsController@goodscate');
Route::get('floor', 'GoodsController@floor');
Route::get('/', function () {
    return view('welcome',['website'=>'Laravel']);
});

