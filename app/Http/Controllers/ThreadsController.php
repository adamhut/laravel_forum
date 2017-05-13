<?php

namespace App\Http\Controllers;

use App\Thread;
use App\ForumChannel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;

class ThreadsController extends Controller
{
    protected static $countPerPage=20;   

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ForumChannel $channel,ThreadFilters $filters)
    {
        //dd($channel);
        //Move it to App serviceprovider as View Composer
        
        $threads = $this->getThreads($channel,$filters);
      
        if(request()->wantsJson())
        {
            return $threads;
        }

        return view('threads.index',compact('threads'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$channels = ForumChannel::all();
        //return view('threads.create',compact('channels'));
        //Create a View Composer on App service provider
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->all();
        // dd(auth()->id());
        //dd(request()->all());
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:forum_channels,id'
        ]);

        $thread =Thread::create([
            'user_id' => auth()->id(),
            'title'=>request('title'),

            'channel_id'=>request('channel_id'),
            'body'=> request('body')
        ]);
        

        return redirect($thread->path())
            ->with('flash','Your thread has been publish');
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $channel
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel,Thread $thread)
    {
        //return $thread->load('replies.favorites')->load('replies.owner');//eager loading to prevent n+1 issues
        //$thread = Thread::find($id);
        //return $thread->replyCount;
        //return Thread::withCount('replies')->first();
        //return $thread->load('replies');
        //return $thread;
        /*
        return view('threads.show',compact('thread'))->with([
            'thread'=> $thread,
            'replies' =>   $thread->replies()->paginate(static::$countPerPage),
           
        ]);*/
        return view('threads.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $channel
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
        /* //Change to Policy  
        if($thread->user_id != auth()->id() )
        {
            abort(403,'You do not have permission to delete this thread');
            if(request()->wantsJson())
            {
                return response(['status'=>'Permission Denied'],403);
            }
            return redirect('/login');
        }
        */
      
        $this->authorize('update',$thread);
        $thread->delete();

        if(request()->wantsJson())
        {
            return response([],204);
        }
        return redirect('threads');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(ForumChannel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        //dd($threads->toSql());
        return $threads->get();
    }
    
}
