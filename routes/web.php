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
//auth()->loginUsingId(1);
//auth()->logout();
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/threads', 'ThreadsController@index');

Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads', 'ThreadsController@store');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');



Route::get('/home', 'HomeController@index');



Route::get('community', 'CommunityLinksController@index');
Route::get('community/{channel}', 'CommunityLinksController@index');
Route::post('community', 'CommunityLinksController@store');

Route::post('votes/{link}','VotesController@store');
