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
Route::get('/ecommerce', 'Ecommerce\EcommerceController@index')->name('ecommerce');

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::resource('products', 'ProductsController', ['except' => ['create', 'edit']]);
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::resource('carts', 'CartsController', ['except' => ['create', 'edit']]);
    Route::post('carts/checkout', 'CartsController@checkout');
});
