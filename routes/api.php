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

Route::get('consignee/{id}', 'App\Http\Controllers\Api\BookingController@consignee_details');
Route::get('consigner/{id}', 'App\Http\Controllers\Api\BookingController@consigner_details');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
