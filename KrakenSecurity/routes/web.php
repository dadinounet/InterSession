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
Route::get('/toto', function () {
    return view('welcome');
});


Route::get('/getProject/{id}', 'ProjectController@getProject')->where('id', '[0-9]+');
Route::get('/mail', 'ProjectController@mail');
Route::get('/allTests', 'ProjectController@allTests');
Route::get('/resultTest/{id}','ProjectController@TesttoJSON')->name('resultTest');

///Route::post('/testproject', 'ProjectController@test')->name('testproject');
//Route::get('/testform', function () {
//    return view('testform');
//});
Route::get('/testform', 'ProjectController@mail');


Route::get("/report/{id}", "ReportController@getReportById")->where('id','[0-9]+');
