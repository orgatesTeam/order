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
     * 驗證 jwt  在驗證使用者狀態
     */
    Route::group(['middleware' => ['jwt.auth', 'checkUser']], function () {
        /**
         * menu
         */
        Route::group(['prefix' => 'menu'], function () {
            Route::post('/list', 'MenuController@list');
            Route::post('/menu-types', 'MenuController@menuTypes');
            Route::post('/update-menu', 'MenuController@updateMenu');
            Route::post('/create-menu', 'MenuController@createMenu');
        });
        /**
         * store
         */
        Route::group(['prefix' => 'store'], function () {
            Route::post('/list', 'StoreController@list');
            Route::post('/create', 'StoreController@create');
            Route::post('/add-menu', 'StoreController@addMenu');
            Route::post('/update', 'StoreController@update');
        });
    });
});




