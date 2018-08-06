<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::get( '{id}/{id2}', function($id){
        return view('admin.index');
    });

    Route::get( '{id}/', function($id){
        return view('admin.index');
    });

    Route::post('login', 'AuthController@login');

    Route::post('order', 'OrderController@index');

    /**
     * 驗證 jwt
     */
    Route::group(['middleware' => 'jwt.auth'], function () {
        //Route::get('order', 'OrderController@index');
    });
});




