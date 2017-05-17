<?php

use App\User;
use Illuminate\Support\Facades\Auth;

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

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');


Route::post('/threads', 'ThreadsController@store');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');



Route::get('/home', 'HomeController@index');


Route::get('community', 'CommunityLinksController@index');
Route::get('community/{channel}', 'CommunityLinksController@index');
Route::post('community', 'CommunityLinksController@store');

Route::post('votes/{link}','VotesController@store');


Route::get('profiles/{user}','ProfilesController@show')->name('profile');	

//Route::get('impersonate/{user}','ImpersonateController@index')

Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\LfmController@upload');



Route::get('impersonate/{user}', 'ImpersonationController')
    ->middleware('can:admin')
    ->name('impersonate');
//Auth::routes();

//Route::get('/home', 'HomeController@index');
