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

Route::get('sql', 'MovieController@store_sql')->name('sql_store');
Route::get('php', 'MovieController@store_php')->name('php_store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
