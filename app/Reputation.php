<?php

namespace App;

class Reputation
{
<<<<<<< HEAD
    const THREAD_WAS_PUBLISHED = 10;    
    const REPLY_POSTED =2;
=======
    const THREAD_WAS_PUBLISHED = 10;

    const REPLY_POSTED = 2;

>>>>>>> 8c4a7579b71aea673c31c7451b0076ee3153129f
    const BEST_REPLY_AWARDED = 50;
    const REPLY_FAVORITED = 5;

    /**
     * Award reputation points to the given user.
     *
     * @param User $user
     * @param int $points
     * @return void
     */
    public static function award($user, $points)
    {
        $user->increment('reputation', $points);
    }

    /**
     * Demote reputation points for the given user.
     *
     * @param User $user
     * @param int $points
     * @return void
     */
    public static function reduce($user, $points)
    {
        $user->decrement('reputation', $points);
    }
}
