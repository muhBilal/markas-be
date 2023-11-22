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
        Route::prefix('auth')->group(function () {
            Route::post('/login', 'AuthController@admin_login');
            Route::post('/logout', 'AuthController@admin_logout');
        });

        Route::apiResource('/regional', 'RegionalController');
        Route::apiResource('/event_album', 'EventAlbumController');
        Route::apiResource('/room_type', 'RoomTypeController');
        Route::apiResource('/activity_type', 'ActivityTypeController');

        Route::get('/room', 'RoomController@index');
        Route::post('/room', 'RoomController@store');
        Route::delete('/room/{id}', 'RoomController@destroy');

        Route::get('/event', 'EventController@index');
        Route::get('/event/{id}', 'EventController@show');
        Route::post('/event', 'EventController@store');
        Route::delete('/event/{id}', 'EventController@destroy');
        
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

        Route::prefix('place')->group(function () {
            Route::get('/', 'PlaceController@index');
            Route::post('/', 'PlaceController@store');
            Route::get('/{id}', 'PlaceController@show');
            Route::put('/{id}', 'PlaceController@update');
            Route::delete('/{id}', 'PlaceController@destroy');
        });

    });
});
