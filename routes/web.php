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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/roles', 'RoleController');
Route::resource('/permissions', 'PermissionController');
Route::resource('/apps', 'AppController');
Route::resource('/users', 'UserController');
Route::resource('/settings', 'SettingController');



Route::post('/settings/upgrade', 'SettingController@upgrade')->name('upgrade');