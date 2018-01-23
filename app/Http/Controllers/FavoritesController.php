<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;
use App\Reputation;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        $reply->favorite();
        //Reputation::award($reply->owner(), Reputation::REPLY_FAVORITED);
        $reply->owner->gainReputation('reply_favorited');

        return back();
        /*
        Favorite::create([
            'user_id' => auth()->id(),
            'favorited_id' => $reply->id,
            'favorited_type' => get_class($reply),
        ]);
        */
       //if(method_exists($this,$property))
       //{
       //   return call_user_func([$this,$property]);
       //}
       //$message = '%s does not respond to the "%s" property or method';
       //throw new \Exception(sprintf($message,static::class,$property));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
        $reply->owner->loseReputation('reply_favorited');
        //Reputation::reduce($reply->owner(), Reputation::REPLY_FAVORITED);
    }
}
