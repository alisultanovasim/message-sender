<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'admin'],function (){
    Route::post('/sendmessage', 'AcceptApiController@sendMessage');
    Route::get('/get-all-statistics', 'AcceptApiController@getStatistics');
// Route::post('/admin/sendmessage/link', 'AcceptApiController@sendMessageLink');
    Route::get('/check-message', 'AcceptApiController@checkMessage');
    Route::get('/date-filter', 'AcceptApiController@dateFilter');
});


