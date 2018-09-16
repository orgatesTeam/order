<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::get('/', function () {
        return view('admin.index');
    });

    /**
     * 調用 vue resource
     */
    Route::get('{id}/', function () {
        return view('admin.index');
    });

    /**
     * 調用 vue resource
     */
    Route::get('{id}/{id2}', function () {
        return view('admin.index');
    });

    Route::post('login', 'AuthController@login');

    /**
     * 驗證 jwt  在驗證使用者狀態
     */
    Route::group(['middleware' => ['jwt.auth', 'checkUser']], function () {
        /**
         * 菜單 menu
         */
        Route::group(['prefix' => 'menu'], function () {

            //取得菜單
            Route::post('/list', 'MenuController@list');

            //所有店家配置菜單以及狀態
            Route::post('/list-by-store-menu', 'MenuController@listByStoreMenu');

            //取得單一店家的菜單,並排序菜單種類
            Route::post('/list-by-store', 'MenuController@listByStore');

            Route::post('/menu-types', 'MenuController@menuTypes');
            Route::post('/update-menu-type','MenuController@updateMenuType');

            Route::post('/update-menu', 'MenuController@updateMenu');
            Route::post('/create-menu', 'MenuController@createMenu');

            Route::post('/search-by-name', 'MenuController@searchMenuByName');
        });
        /**
         * 口味 taste
         */
        Route::group(['prefix' => 'taste'], function () {
            Route::post('/list', 'TasteController@list');
            Route::post('/new', 'TasteController@new');
            Route::post('/update', 'TasteController@update');
            Route::post('/delete', 'TasteController@delete');
        });
        /**
         * 店家 store
         */
        Route::group(['prefix' => 'store'], function () {
            Route::post('/list', 'StoreController@list');
            Route::post('/create', 'StoreController@create');
            Route::post('/add-menu', 'StoreController@addMenu');
            Route::post('/update', 'StoreController@update');
            Route::post('/setting-table-total', 'StoreController@settingTableTotal');
        });
    });
});




