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

use App\Category;

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

        // Brand Routes Functions
        // Display Brands
        Route::get('brands', 'BrandController@brands');
        // Add Edit Brands
        Route::match(['get', 'post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');
        // Change Brand Status
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        // Delete Brand
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');
        
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

        // Products
        // Display Products
        Route::get('products', 'ProductsController@products');
        // Change Products Status
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        // Add Edit Products
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        // Delete Product Image
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        // Delete Product Video
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');
        // Delete Product
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');

        // Attributes
        // Add Attributes
        Route::match(['get', 'post'], 'add-attributes/{id}', 'ProductsController@addAttributes');
        // Edit Attributes
        Route::post('edit-attributes/{id}', 'ProductsController@editAttributes');
        // Change Attribute Status
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        // Delete Product
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');

        // Images
        // Add Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        // Change Image Status
        Route::post('update-image-status', 'ProductsController@updateImageStatus');
        // Delete Product Image
        Route::get('delete-image/{id}', 'ProductsController@deleteImage');

        // Display Banners
        Route::get('banners','BannersController@banners');
        // Add Edit Banner
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');
        // Change Banners Status
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        // Delete Banner Image
        Route::get('delete-banner/{id}', 'BannersController@deleteBannerImage');
    });
    
    // Login
    Route::match(['get', 'post'], '/', 'AdminController@login');
});

// Frontend Routes
Route::namespace('Front')->group(function(){
    // Index
    Route::get('/','IndexController@index');
    // Listing Page
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $url) {
        Route::get('/'.$url, 'ProductsController@listing');
    }
    // Detail Products
    Route::get('/product/{id}', 'ProductsController@detail');
}); 