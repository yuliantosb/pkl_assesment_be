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

Route::middleware(['auth:api'])->group(function(){
    Route::get('/todo', 'Api\TodoController@index');
    Route::post('/todo', 'Api\TodoController@store');
    Route::get('/todo/toggle/{id}', 'Api\TodoController@toggle');
    Route::get('/todo/{id}', 'Api\TodoController@show');
    Route::post('/todo/{id}', 'Api\TodoController@update');
    Route::delete('/todo/{id}', 'Api\TodoController@destroy');
});

// register
Route::post('/register', 'Api\AuthController@register');
// login
Route::post('/login', 'Api\AuthController@login');