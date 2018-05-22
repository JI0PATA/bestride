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

Auth::routes();

Route::get('/', 'HomeController@index')->name('index');

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function() {
    Route::get('/', 'ProfileController@index')->name('index');

    Route::prefix('rides')->name('rides.')->group(function() {
        Route::get('add', 'RideController@add')->name('add');
        Route::post('create', 'RideController@create')->name('create');
        Route::get('delete/{id}', 'RideController@delete')->name('delete');

        Route::get('join/{id}', 'RideController@join')->name('join');
        Route::get('unjoin/{id}', 'RideController@unjoin')->name('unjoin');
    });
});
