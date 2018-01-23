<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //

    use Favoritable, RecordActivity;

    protected $fillable = [
        'body',
        'user_id',
    ];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['isFavorited', 'favoritesCount', 'isBest'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');


            $reply->owner->gainReputation('reply_posted');
            // $reply->owner->increment('reputation', 2);
            //Reputation::award($reply->owner, Reputation::REPLY_POSTED);
        });

        static::deleted(function ($reply) {
            if ($reply->isBest()) {
                //$reply->thread->update(['best_reply_id'=>null]);
            }
            $reply->thread->decrement('replies_count');

            $reply->owner->loseReputation('reply_posted');
            //Reputation::reduce($reply->owner, Reputation::REPLY_POSTED);
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path()."#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
             $body
        ); //hello @JaneDoe
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     * Determind the current reply is the best Reply.
     *
     * @return void
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }
}
