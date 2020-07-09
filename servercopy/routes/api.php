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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user', function (Request $request) {
        $request->user()->groups;
        $request->user()->events;
        return $request->user();
    });
    Route::post('/logout', 'API\AuthController@logout');
    });
    Route::get('/users', function () {
        return App\User::all();
    });
Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');

Route::get('/events', 'API\EventController@index');
Route::post('/events', 'API\EventController@store');
Route::get('/events/{event}', 'API\EventController@show');
Route::post('events/{event}/attach/{user}', 'API\EventController@storeExperts');
Route::patch('/events/{event}', 'API\EventController@update');
Route::delete('/events/{event}', 'API\EventController@destroy');


Route::post('/tasks', 'API\TaskController@store');
Route::get('/tasks', 'API\TaskController@index');
Route::get('/tasks/{task}','API\TaskController@show');
Route::patch('/tasks/{task}','API\TaskController@update');
Route::delete('/tasks/{task}','API\TaskController@destroy');

Route::post('groups/{group}/attach/{user}','API\GroupController@storePart');
Route::post('/groups', 'API\GroupController@store');
Route::get('/groups', 'API\TaskController@index');
Route::get('/groups/{group}','API\TaskController@show');
Route::patch('/groups/{group}','API\TaskController@update');
Route::delete('/groups/{group}','API\TaskController@destroy');

Route::post('/results', 'API\ResultController@store');
Route::get('/results', 'API\ResultController@index');
Route::get('/results/{result}','API\ResultController@show');
Route::patch('/results/{result}','API\ResultController@update');
Route::delete('/results/{result}','API\ResultController@destroy');

Route::post('/reviews', 'API\ReviewController@store');
Route::get('/reviews', 'API\ReviewController@index');
Route::get('/reviews/{review}','API\ReviewController@show');
Route::patch('/reviews/{review}','API\ReviewController@update');
Route::delete('/reviews/{review}','API\ReviewController@destroy');
