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
Route::get('/', function () {
    return redirect()->route('photos.index');
});

Route::get('photos', 'PhotosController@index')->name('photos.index');

Route::get('orders', 'OrdersController@index')->name('orders.index');
Route::post('orders', 'OrdersController@store')->name('orders.store');
Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');

Route::get('orders/{order}/payments/pse', 'PaymentAttemptsController@create')->name('orders.payments.pse.create');
Route::post('orders/{order}/payments/pse', 'PaymentAttemptsController@store')->name('orders.payments.pse.store');

