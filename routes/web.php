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
Route::get('/buy',  'BuyController@index');
Route::post('/buy/search',  'BuyController@search');
Route::post('/buy/process',  'BuyController@process');


Route::get('/sell', 'SellController@index');
Route::post('/sell', 'SellController@sell');
Route::get('/sell/{id}', 'SellController@process');

Route::get('/confirm', 'TransactionsController@index');
Route::post('/confirm', 'TransactionsController@process');
