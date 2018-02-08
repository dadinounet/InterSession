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

Route::post('login', 'PassportController@login')->name('login');

Route::post('register', 'PassportController@register')->name('register');

Route::get('disconnect', 'PassportController@disconnect')->middleware('auth:api')->name('disconnect');

Route::get('userdetails', 'PassportController@getDetails')->middleware('auth:api')->name('userdetails');

Route::post('/newProject', 'ProjectController@test')->middleware('auth:api')->name('newProject');

Route::get('/resultToJson/{id}','ProjectController@TesttoJSON')->middleware('auth:api')->name('resultToJson');

Route::post();
//Route::get('testproject/{git}', 'ProjectController@test')->middleware('auth:api')->name('testproject');

/*Route::middleware('auth:api')->group(function() {
    Route::post('get-details', 'PassportController@getDetails');
});*/
//Route::post('get-details', 'PassportController@getDetails')->middleware('client');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


