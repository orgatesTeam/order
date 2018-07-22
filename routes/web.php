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

//開發管理者平台
Route::group(['namespace' => 'Super', 'prefix' => 'super'], function () {

    //參數管理模塊
    Route::group(['prefix' => 'parameters'], function () {
        Route::get('/', 'ParametersController@index');
        Route::get('/all', 'ParametersController@all')->name('parameters.all');
        Route::post('/update', 'ParametersController@update')->name('parameters.update');
    });

});


