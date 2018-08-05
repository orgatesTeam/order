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

Route::get('/', 'Super\UsersController@index');

//開發管理者平台
Route::group(['namespace' => 'Super', 'prefix' => 'super', 'as' => 'super.'], function () {

    //參數管理模塊
    Route::group(['prefix' => 'parameters','as' => 'parameters.'], function () {
        Route::get('/', 'ParametersController@index')->name('index');
        //ajax
        Route::get('/all', 'ParametersController@all')->name('all');
        Route::post('/update', 'ParametersController@update')->name('update');
    });

    //帳號管理模塊
    Route::group(['prefix' => 'users','as' => 'users.'], function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/create', 'UsersController@create')->name('create');
        Route::get('/update', 'UsersController@update')->name('update');

        //ajax
        Route::group(['namespace' => 'Api','prefix' => 'ajax','as' => 'ajax.'], function () {
            Route::get('/list', 'UsersController@list')->name('list');
            Route::get('/check-value-exist', 'UsersController@checkValueExist')->name('check');
            Route::post('/store', 'UsersController@store')->name('store');
        });

    });

});


