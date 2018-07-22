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

Route::group(['namespace' => 'Super', 'prefix' => 'super'], function () {
    Route::get('/parameters', 'ParametersController@index');
    Route::get('/parameters/all', 'ParametersController@all')->name('parameters.all');
    Route::post('/parameters/update', 'ParametersController@update')->name('parameters.update');
});


