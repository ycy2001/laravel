<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('goodscart', 'VueController@goodscart');
    Route::post('goodscartshow', 'VueController@goodscartshow');
    Route::post('addUpdate', 'VueController@addUpdate');
    Route::post('jianUpdate', 'VueController@jianUpdate');
    Route::post('address', 'VueController@addressadd');
    Route::post('order', 'VueController@order');
    Route::post('getaddress', 'VueController@getaddress');
    Route::post('confirm', 'VueController@confirm');
});
Route::post('product', 'GoodsController@product');
Route::post('area', 'GoodsController@area');
Route::get('index', 'PayController@index');
Route::get('return', 'PayController@return');
Route::get('notify', 'PayController@notify');