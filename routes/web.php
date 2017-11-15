 <?php

use App\User;
use Pusher\Pusher;
use App\ChatMessage;
use App\Events\ChatMessageWasReceived;
use App\Notifications\YouWereMentioned;
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
//
Route::get('notifytest',function(){

    $reply = App\Reply::first();
    //dd($reply);
    auth()->user()->notify(new YouWereMentioned($reply));

});
Route::get('grid',function(){
    return view('grid');
});
Route::get('grid-nav',function(){
    return view('gridnav');
});
Route::get('grid-nest',function(){
    return view('gridnest');
});
Route::get('grid-autofill',function(){
    return view('gridautofill');
});
Route::get('/pusher',function(){
 	  /*$user = User::first();
    $message = ChatMessage::create([
        'user_id' => $user->id,
        'message' => 'hello world'
    ]);*/

    return view('pusher.index');
	/*
	$options = array(
    'encrypted' => true
  	);
  	$pusher = new Pusher(
    	'b12fcbcf3175a9c80082',
    	'5ea3ee3811bf7e9a4397',
    	'403050',
    	$options
  	);

  	$data['message'] = 'hello world';
  	$pusher->trigger('my-channel', 'my-event', $data);
  	*/
	// /    event(new ChatMessageWasReceived($message, $user));

});

Route::get('/vuex_start',function(){
  return view('vue_start');
});
Route::get('/vuex',function(){
  return view('vuex');
});

Route::view('scan','scan');


//
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

Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed');

Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/search', 'SearchController@show');
Route::get('/threads/{channel}', 'ThreadsController@index');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::patch('/threads/{channel}/{thread}', 'ThreadsController@update');

Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::post('/threads/{channel}/{thread}/favorites', 'FavoriteThreadsController@store');
Route::delete('/threads/{channel}/{thread}/favorites', 'FavoriteThreadsController@destroy');

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get( '/threads/{channel}/{thread}/replies', 'RepliesController@index');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/replies/{reply}/best','BestReplyController@store')->name('best-replies.store');

Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destory');

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

Route::get('/register/confirm','Auth\RegisterConfirmationController@index')->name('register.confirm');


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


Route::group(['middleware'=>'auth'],function(){
    Route::get('/chat', 'ChatsController@index');
    Route::get('messages', 'ChatsController@show');
    Route::post('messages', 'ChatsController@store');
    Route::get('testmessages', function(){
        $user = auth()->user();
        $message = App\Message::first();
        //dd($message);
        broadcast(new App\Events\MessageSent($user, $message))->toOthers();
         /*$options = array(
       'encrypted' => true
     );
     $pusher = new Pusher\Pusher(
       'b12fcbcf3175a9c80082',
       '5ea3ee3811bf7e9a4397',
       '403050',
       $options
     );

     $data['message'] = 'hello world';
     $pusher->trigger('my-channel', 'my-event', $data);
    */

    });
});
