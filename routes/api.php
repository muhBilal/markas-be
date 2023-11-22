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
    });
});
