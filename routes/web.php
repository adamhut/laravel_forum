 <?php

use App\User;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Redis;

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

	//$visit = Redis::incr('visit');
	//return $visit;
    return view('welcome');
});
Route::get('test', function () {

	Collection::marco('trnaspose', function(){
		$items = array_map(function(...$items){
			return $items;
		},...$this->values());

		return new static($items);
	});
});

Auth::routes();

Route::get('/threads', 'ThreadsController@index');
Route::post('/threads', 'ThreadsController@store');

Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}', 'ThreadsController@index');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads/{channel}/{thread}/favorites', 'FavoriteThreadsController@store');
Route::delete('/threads/{channel}/{thread}/favorites', 'FavoriteThreadsController@destroy');

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get( '/threads/{channel}/{thread}/replies', 'RepliesController@index');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');


Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');


Route::get('/home', 'HomeController@index');


Route::get('community', 'CommunityLinksController@index');
Route::get('community/{channel}', 'CommunityLinksController@index');
Route::post('community', 'CommunityLinksController@store');

Route::post('votes/{link}','VotesController@store');


Route::get('profiles/{user}','ProfilesController@show')->name('profile');	
Route::delete('profiles/{user}/noticiations/{notification}','UserNotificationsController@destroy');
Route::get('profiles/{user}/noticiations','UserNotificationsController@index');

Route::get('api/users','Api\UsersController@index');
Route::post('api/users/{user}/avatar','Api\UserAvatarController@store')->middleware('auth')->name('avatar');


//Route::get('impersonate/{user}','ImpersonateController@index')

Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\LfmController@upload');


Route::get('impersonate/{user}', 'ImpersonationController')
    ->middleware('can:admin')
    ->name('impersonate');
//Auth::routes();

//Route::get('/home', 'HomeController@index');
