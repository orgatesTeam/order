<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::get('/', function () {
        return view('admin.index');
    });

    /**
     * 調用 vue resource
     */
    Route::get('{id}/', function ($id) {
        return view('admin.index');
    });

    /**
     * 調用 vue resource
     */
    Route::get('{id}/{id2}', function ($id) {
        return view('admin.index');
    });

    Route::post('login', 'AuthController@login');

    /**
     * 驗證 jwt
     */
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('menu/list', 'MenuController@list');
        Route::post('menu/menu-types', 'MenuController@menuTypes');
        Route::post('menu/update-menu', 'MenuController@updateMenu');
        Route::post('menu/create-menu', 'MenuController@createMenu');

    });
});




