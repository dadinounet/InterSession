<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'ProjectController@test');
Route::get('/getProject/{id}', 'ProjectController@getProject')->where('id', '[0-9]+');
Route::get('/mail', 'ProjectController@mail');
Route::get('/allTests', 'ProjectController@allTests');


Route::get("/report/{id}", "ReportController@getReportById")->where('id','[0-9]+');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
