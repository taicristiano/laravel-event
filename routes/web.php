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
Route::get('/test-event', [
    'uses' => 'EventController@testEvent',
    'as' => 'test-event',
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test-queue', [
    'uses' => 'QueueController@testQueue',
    'as' => 'test-queue',
]);

Route::get('gate', [
    'uses' => 'AuthorizationController@testEditComment',
    'as' => 'test-gate',
    // 'middleware' => 'can:edit-comment,test'
]);

Route::get('policy/{id}', [
    'uses' => 'AuthorizationController@testPolicy',
    'as' => 'test-policy',
    // 'middleware' => 'can:edit-comment,test'
]);
