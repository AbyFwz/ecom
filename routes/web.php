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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function () {
    // All admin route will defined here

    Route::group(['middleware' => 'admin'], function () {
        // Dashboard
    Route::get('dashboard', 'AdminController@dashboard');    
    });

    // Login
    Route::match(['get', 'post'], '/', 'AdminController@login');
});
