<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    /**
     * 調用 vue resource
     */
    Route::get( '{id}/{id2}', function($id){
        return view('admin.index');
    });

    /**
     * 調用 vue resource
     */
    Route::get( '{id}/', function($id){
        return view('admin.index');
    });

    Route::post('login', 'AuthController@login');

    /**
     * 驗證 jwt
     */
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('menu/list', 'MenuController@list');
    });
});




