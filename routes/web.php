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

Route::match(['get', 'post'], '/', 'LoginController@index')->name('login');
Route::match(['get', 'post'], '/register', 'LoginController@register');
Route::get('/logout', 'LoungeController@logout');

Route::group(['middleware' => ['checklogin']], function () {
    Route::get('/lounge', 'LoungeController@index');
    Route::match(['get', 'post'], '/create', 'LoungeController@create');
    Route::get('/room/{id}', 'RoomController@index');
    Route::post('/bind', 'RoomController@bind');
    Route::post('/say', 'RoomController@say');
    Route::post('/flush', 'RoomController@flush');
    Route::get('/leave', 'RoomController@leave');
});