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
Route::get('/events', 'EventController@index');
Auth::routes();
Route::middleware('auth')->group(function() {
    Route::get('/events/create','EventController@create');
    Route::post('/events', 'EventController@store');
    Route::get('/events/{event}/edit', 'EventController@edit');
    Route::delete('/events/{event}', 'EventController@destroy');
    Route::put('/events/{event}', 'EventController@update');
    Route::patch('/events/{event}/finish', 'EventController@finish');
    Route::post('/events/{event}/attachExpert', 'EventController@storeExpert');
});

Route::get('/events/{event}','EventController@show');

Route::get('/tasks/{task}','TaskController@show');
Route::post('/tasks/{event}', 'TaskController@store');
Route::get('/tasks/{task}/edit', 'TaskController@edit');
Route::patch('/tasks/{task}', 'TaskController@update');

Route::post('/groups/{event}', 'GroupController@store');
Route::post('/groups/{group}/attach', 'GroupController@storeParticipant');
Route::get('/groups/{group}', 'GroupController@show');
Route::get('/profile','UserController@show');
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/results/{task}', 'ResultController@store');
Route::get('/results/{result}','ResultController@show');

Route::post('/reviews/{result}', 'ReviewController@store');

