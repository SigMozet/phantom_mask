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
    //以指定星期幾、時間搜尋營業藥局
    Route::post('openOnTime', 'App\Http\Controllers\PharmaciesController@checkOpenAtTime');

    //以指定星期幾，搜尋營業藥局
    Route::post('openAtDay', 'App\Http\Controllers\PharmaciesController@checkOpenOnDay');

    //以藥局ID搜尋該藥局販售的口罩
    Route::get('getProduct/{phar_id}', 'App\Http\Controllers\PharmaciesController@getProduct');

    //透過關鍵字搜尋符合名稱的藥局
    Route::get('search/{phar_name}', 'App\Http\Controllers\PharmaciesController@search');

    //找出符合價錢區間的口罩A，並找出A的庫存量符合標準的藥局
    Route::post('searchByPriceAndStock', 'App\Http\Controllers\PharmaciesController@searchByPriceAndStock');

    //編輯藥局名稱
    Route::post('editName', 'App\Http\Controllers\PharmaciesController@editName');
});

Route::prefix('Masks')->group(function () {
    //透過關鍵字搜尋符合名稱的口罩
    Route::get('search/{mask_name}', 'App\Http\Controllers\MasksController@search');

    //編輯口罩名稱
    Route::post('editName', 'App\Http\Controllers\MasksController@editName');

    //編輯口罩名稱
    Route::post('editPrice', 'App\Http\Controllers\MasksController@editPrice');

    //編輯口罩名稱
    Route::post('deleteMask', 'App\Http\Controllers\MasksController@delete');
});