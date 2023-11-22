<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('admin/auth')->group(function () {
            Route::post('/login', 'AuthController@admin_login');
            Route::post('/logout', 'AuthController@admin_logout');
        });

        Route::prefix('testimonial')->group(function () {
            Route::get('/', 'TestimonialController@index');
            Route::post('/', 'TestimonialController@store');
            Route::get('/{id}', 'TestimonialController@show');
            Route::put('/{id}', 'TestimonialController@update');
            Route::delete('/{id}', 'TestimonialController@destroy');
        });

        Route::prefix('transaction')->group(function () {
            Route::get('/', 'TransactionController@index');
            Route::post('/', 'TransactionController@store');
            Route::get('/{id}', 'TransactionController@show');
            Route::delete('/{id}', 'TransactionController@destroy');
        });

        Route::prefix('Place')->group(function () {
            Route::get('/', 'PlaceController@index');
            Route::post('/', 'PlaceController@store');
            Route::get('/{id}', 'PlaceController@show');
            Route::put('/{id}', 'PlaceController@update');
            Route::delete('/{id}', 'PlaceController@destroy');
        });

        Route::prefix('Place')->group(function () {
            Route::get('/', 'PlaceController@index');
            Route::post('/', 'PlaceController@store');
            Route::get('/{id}', 'PlaceController@show');
            Route::put('/{id}', 'PlaceController@update');
            Route::delete('/{id}', 'PlaceController@destroy');
        });


    });
});
