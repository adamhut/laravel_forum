<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $mentionedUsers=$event->reply->mentionedUsers();

        collect($mentionedUsers)
            ->map(function($name){
                return User::where('name',$name)->first();
            })
            ->filter()
            ->each(function($user) use($event){
                //and then for each mentioned user , notify them
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
