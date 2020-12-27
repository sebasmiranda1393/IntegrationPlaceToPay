<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('productos');
});

route::resource('productos', ProductController::class)->only(["index"]);

route::resource('carts', CartController::class)->only(["show", "index"]);
Route::group(['prefix' => 'carts'], function () {
    Route::get('empty/{id}', 'CartController@empty')->name('carts.empty');
    Route::get('destroy/{id}', 'CartController@destroy')->name('carts.destroy');
    Route::get('increaseProduct/{id}', 'CartController@increaseProduct')->name('carts.increaseProduct');
    Route::get('decreaseProduct/{id}', 'CartController@decreaseProduct')->name('carts.decreaseProduct');

});

route::resource('buyCart', BuyCartController::class)->only(["store"]);
