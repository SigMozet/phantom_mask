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
    return csrf_token();
});


//Route::get('openOnTime', 'App\Http\Controllers\PharmaciesController@checkOpen');

Route::get('token', 'App\Http\Controllers\CsrfController@token');

Route::prefix('Pharmacies')->group(function () {
    Route::post('openOnTime', 'App\Http\Controllers\PharmaciesController@checkOpenAtTime');
    Route::post('openAtDay', 'App\Http\Controllers\PharmaciesController@checkOpenOnDay');
    Route::get('getProduct/{phar_id}', 'App\Http\Controllers\PharmaciesController@getProduct');
    Route::get('search/{phar_name}', 'App\Http\Controllers\PharmaciesController@search');
    Route::post('searchByPriceAndStock', 'App\Http\Controllers\PharmaciesController@searchByPriceAndStock');
});

Route::prefix('Masks')->group(function () {
    Route::get('search/{mask_name}', 'App\Http\Controllers\MasksController@search');
});