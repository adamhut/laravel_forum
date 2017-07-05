<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {   
        /*
        if($user->isAdmin())
        {
            return true;
        }
        */
    }

    /**
     * Determine whether the user can update the Reply .
     *
     * @param  \App\User  $user
     * @param  \App\Reply  $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        
        // dd($thread->user_id , $user->id);
        return $reply->user_id == $user->id;
    }

    public function create(User $user)
    {
        $lastReply = $user->fresh()->lastReply;

        if(!$lastReply)
        {
            return true;
        }
        return !$lastReply->wasJustPublished();
    }
}
