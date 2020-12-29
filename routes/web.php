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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function () {
    // All admin route will defined here

    Route::group(['middleware' => 'admin'], function () {
        // Dashboard
        Route::get('dashboard', 'AdminController@dashboard');    

        // Main Admin Routes Functions
        // Settings
        Route::get('settings', 'AdminController@settings');
        // Check Current Password
        Route::post('check-current-pwd', 'AdminController@chkCurrentPassword');
        // Update Password
        Route::post('update-pwd', 'AdminController@updateCurrentPassword');
        // Update Admin Details
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');
        // Logout
        Route::get('logout', 'AdminController@logout');

        // Section Routes Functions
        // Display Sections
        Route::get('sections', 'SectionController@sections');
        // Change Section Status
        Route::post('update-section-status', 'SectionController@updateSectionStatus');

        // Category Routes Functions
        // Display Categories
        Route::get('categories', 'CategoryController@categories');
        // Change Category Status
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        // Add Edit Category
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        // Append Category Level
        Route::post('append-categories-level', 'CategoryController@appendCategoryLevel');
        // Delete Category Image
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
        // Delete Category
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');
    });
    
    // Login
    Route::match(['get', 'post'], '/', 'AdminController@login');
});

// Frontend Routes
Route::namespace('Front')->group(function(){
    // Index
    Route::get('/','IndexController@index');
}); 