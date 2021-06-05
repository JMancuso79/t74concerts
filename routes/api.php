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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment', 'App\Http\Controllers\PaymentController@validateForm');
Route::post('/send-message', 'App\Http\Controllers\ContactController@sendMessage');
Route::post('/booking-request', 'App\Http\Controllers\BookingController@store');
Route::get('/get/promo-codes/{concer_id}', 'App\Http\Controllers\PaymentController@getPromoCodes');
Route::get('/get/promo-codes-all/{concer_id}', 'App\Http\Controllers\PaymentController@getAllPromoCodes');