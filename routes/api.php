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
Route::post('login', 'UserController@login');
Route::post('store', 'UserController@store');
Route::post('storecategory','CategoryController@store');
Route::post('index','CategoryController@index');
Route::post('destroy','CategoryController@destroy');
Route::post('updateCategory','CategoryController@updateCategory');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});
