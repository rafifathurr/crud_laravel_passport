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
Route::namespace('App\Http\Controllers\Api')->group(function (){
    Route::post('/register', 'Auth\AuthController@register');
    Route::post('/login', 'Auth\AuthController@login');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::Resource('/students', 'StudentsController');
        Route::post('/students/search', 'StudentsController@search');
        Route::post('/logout', 'Auth\AuthController@logout');
    });
});
