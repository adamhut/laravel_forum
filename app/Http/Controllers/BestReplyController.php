<?php

namespace App\Http\Controllers;

use App\Reply;

class BestReplyController extends Controller
{
    public function store(Reply $reply)
    {
        //dd($reply->thread->user_id , auth()->id());
        //abort_if($reply->thread->user_id != auth()->id(),401);

        //	$this->authorize('update',$reply->thread);

        // /$reply->thread->update(['best_reply_id'=>$reply->id]);

        $reply->thread->markAsBestReply($reply);
    }
}
