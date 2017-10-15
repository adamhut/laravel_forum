<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class LockedThreadsController extends Controller
{
    //
    public function store(Thread $thread)
    {
        //if(! auth()->user()->isAdmin()){
        //    return response('You do not have a permission to lock this thread',403);
        //}

        $thread->lock();
            // /dd(2);
    }
}
