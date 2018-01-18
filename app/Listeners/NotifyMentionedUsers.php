<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        //inspect the body of the reply for username mention
        User::whereIn('name', $event->reply->mentionedUsers())
            ->each(function ($user) use ($event) {
                //and then for each mentioned user , notify them
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
