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
Route::get('notifytest', function () {
    $reply = App\Reply::first();
    //dd($reply);
    auth()->user()->notify(new YouWereMentioned($reply));
});
Route::get('grid', function () {
    return view('grid');
});
Route::get('grid-nav', function () {
    return view('gridnav');
});
Route::get('grid-nest', function () {
    return view('gridnest');
});
Route::get('grid-autofill', function () {
    return view('gridautofill');
});
Route::get('/pusher', function () {
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

Route::get('/vuex_start', function () {
    return view('vue_start');
});
Route::get('/vuex', function () {
    return view('vuex');
});

Route::view('scan', 'scan');

//
Route::get('/', function () {

    //$visit = Redis::incr('visit');
    //return $visit;
    return view('welcome');
});
Route::get('test', function () {
    Collection::marco('trnaspose', function () {
        $items = array_map(function (...$items) {
            return $items;
        }, ...$this->values());

        return new static($items);
    });
});

Route::get('jobs', function () {
    dispatch(new App\Jobs\PerformRunningThing)->delay(now()->addMinutes(3));
});

Auth::routes();

Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::post('/threads', 'ThreadsController@store')->middleware('must-be-confirmed')->name('threads.store');

Route::get('/threads/create', 'ThreadsController@create')->middleware('must-be-confirmed')->name('threads.create');
Route::get('/threads/search', 'SearchController@show')->name('search.show');
Route::get('/threads/{channel}', 'ThreadsController@index')->name('channels');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::patch('/threads/{channel}/{thread}', 'ThreadsController@update');

Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::post('/threads/{channel}/{thread}/favorites', 'FavoriteThreadsController@store');
Route::delete('/threads/{channel}/{thread}/favorites', 'FavoriteThreadsController@destroy');

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/replies/{reply}/best', 'BestReplyController@store')->name('best-replies.store');

Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destory');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorite');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/home', 'HomeController@index');

Route::get('community', 'CommunityLinksController@index');
Route::get('community/{channel}', 'CommunityLinksController@index');
Route::post('community', 'CommunityLinksController@store');

Route::post('votes/{link}', 'VotesController@store');

Route::get('profiles/{user}', 'ProfilesController@show')->name('profile');
Route::delete('profiles/{user}/noticiations/{notification}', 'UserNotificationsController@destroy');
Route::get('profiles/{user}/noticiations', 'UserNotificationsController@index');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

//Route::get('impersonate/{user}','ImpersonateController@index')

Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\LfmController@upload');

Route::get('impersonate/{user}', 'ImpersonationController')
    ->middleware('can:admin')
    ->name('impersonate');
//Auth::routes();

//Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>'auth'], function () {
    Route::get('/chat', 'ChatsController@index');
    Route::get('messages', 'ChatsController@show');
    Route::post('messages', 'ChatsController@store');
    Route::get('testmessages', function () {
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

Route::group(['prefix' => 'wesbos'], function () {
    Route::get('grid02', function () {
        return view('wesbos.02');
    });
    Route::get('grid03', function () {
        return view('wesbos.03');
    });
    Route::get('grid04', function () {
        return view('wesbos.04');
    });
    Route::get('grid05', function () {
        return view('wesbos.05');
    });
    Route::get('grid06', function () {
        return view('wesbos.06');
    });
    Route::get('grid07', function () {
        return view('wesbos.07');
    });
    Route::get('grid08', function () {
        return view('wesbos.08');
    });
    Route::get('grid09', function () {
        return view('wesbos.09');
    });
    Route::get('grid10', function () {
        return view('wesbos.10');
    });
    Route::get('grid11', function () {
        return view('wesbos.11');
    });
    Route::get('grid12', function () {
        return view('wesbos.12');
    });
    Route::get('grid13', function () {
        return view('wesbos.13');
    });
    Route::get('grid14', function () {
        return view('wesbos.14');
    });
    Route::get('grid14-2', function () {
        return view('wesbos.14-2');
    });
    Route::get('grid15', function () {
        return view('wesbos.15');
    });

    Route::get('grid16', function () {
        return view('wesbos.16');
    });
    Route::get('grid17', function () {
        return view('wesbos.17');
    });
    Route::get('grid18', function () {
        return view('wesbos.18');
    });
    Route::get('grid19', function () {
        return view('wesbos.19');
    });

    Route::get('grid20', function () {
        return view('wesbos.20');
    });
    Route::get('grid21', function () {
        return view('wesbos.21');
    });
    Route::get('grid22', function () {
        return view('wesbos.22');
    });
    Route::get('grid23', function () {
        return view('wesbos.23');
    });
});
