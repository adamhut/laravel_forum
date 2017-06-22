<?php

namespace App\Http\Controllers;


use App\Reply;
use App\Thread;
use App\Inspection\Spam;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channelID, Thread $thread)
    {
        return $thread->replies()->paginate(10);
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
     * @param  string $cahnnelId 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspection\Spam  $spam
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, Spam  $spam)
    {
        $this->validate(request(),[
            'body' => 'required',
        ]);

        $spam->check(request('body'));
        // check ,spam
       

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            
            return $reply->load('owner');
        }
        return back()->with('flash','your reply has been left!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        //
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        $this->authorize('update',$reply);
        $reply->update(['body'=>request('body')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        /*//change to use policy
        if($reply->user_id != auth()->id())
        {
            return response([],403);
        }
        */
        $this->authorize('update',$reply);

        
        $reply->delete();


        if(request()->expectsJson())
        {
            return response(['status'=>'Your Reply has been deleted']);
        }

        return back();
    }
}
