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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::post('login', 'AuthController@login');

    Route::post('order', 'OrderController@index');

    /**
     * 驗證 jwt
     */
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('order', 'OrderController@index');
    });
});




