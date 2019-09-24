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

Route::get('/', 'OgrnController@showValidationForm');
Route::post('/ogrn/validate', 'OgrnController@validateOgrn');
Route::get('/ogrn/show-currency-form', 'OgrnController@showCurrencyForm');
Route::get('/ogrn/get-currency-by-date', 'OgrnController@getCurrencyByDate');
