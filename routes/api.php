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

Route::middleware('auth:api')->group(function() {

    Route::get('products','ProductController@index');
    Route::post('products','ProductController@store')->middleware(['role:submitter']);
    Route::put('products/{product}','ProductController@update')->middleware(['role:submitter']);
    Route::delete('products/{product}','ProductController@destroy')->middleware(['role:submitter']);

    Route::put('products/{product}/approve','ProductController@approve')->middleware(['role:approver']);

});

Route::post('login','AuthController@login');