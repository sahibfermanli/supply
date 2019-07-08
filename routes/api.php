<?php

use Illuminate\Http\Request;

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

Route::get('/404', 'Api\MissingController@not_found');
Route::get('/message', 'Api\MessageController@message');

Route::post('/orders', 'Api\OrdersController@get_orders')->middleware('ApiLogin');
