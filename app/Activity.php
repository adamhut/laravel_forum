<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $guarded = [];

    public function subject()
    {
        //This will find out what the relative activity it related to
        return $this->morphTo();
    }

    public static function feed(User $user, $take = 50)
    {
        //return $user->activity()
        return static::where('user_id', $user->id)
            ->with('subject')
            ->latest()
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
