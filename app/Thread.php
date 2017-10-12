<?php

namespace App;


use App\Favoritable;
use App\ForumChannel;
use App\Events\ThreadHasNewReply;
use App\Exceptions\ThreadIsLocked;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    use RecordActivity,Favoritable;


    protected $guarded =[];

    /**
     * The relationship to always eager-load
     *
     * @var array
     */
    protected $with=['creator','channel'];

    /**
     * The attribute to always appends
     *
     * @var array
     */
    protected $appends=['isSubscribedTo'];

    protected static function boot(){
        parent::boot();

         /*
        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });

        static::addGlobalScope('creator', function($builder){
            $builder->with('creator');
        });
        //in code you can add  App\Thread::withoutGlobalScopes()->first()//to disable it
        */


        static::deleting(function($thread){
            $thread->replies()->each(function($reply){
                $reply->delete();
            });
        });

        static::created(function($thread){
            $thread->update(['slug'=> $thread->title]);
        });

        /* move to RecordActivity trait
        static::created(function($thread){
            $thread->recordActivity('create');
        });
        */
    }


    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function replies()
    {
        //return $this->hasMany(Reply::class)->withCount('favorites');

        //load the reply with the favorites count
    	return $this->hasMany(Reply::class);
           // ->withCount('favorites')
            //->with('owner');
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }

    public function scropReplyCount($query)
    {

    }

    public function addReply($reply)
    {
        if($this->locked){
            throw new ThreadIsLocked('Thread is Lock');
        }
        $reply =  $this->replies()->create($reply);

        //$this->increment('replies_count');

        //prepare all notification to all subscribers.

        event(new ThreadReceivedNewReply($reply));

        //event(new ThreadHasNewReply($this,$reply));
        //$this->notifySubscribers($reply);
        /*
        $this->subscriptions
            ->where('user_id','!=',$reply->user_id)
            ->each
            ->notify($reply);
        */
        /*
        $this->subscriptions
            ->filter(function($subscription) use ($reply){
                return $subscription->user_id != $reply->user_id;
            })
            ->each->notify($reply);
        */
            /*
            ->each(function($subscription)use ($reply){
                //$subscription->user->notify(new ThreadWasUpdated($this,$reply));
                $subscription->notify($reply);
            });
            */
        /*
        foreach($this->subscriptions as $subscription){
            if($subscription->user_id != $reply->user_id)
            {
                $subscription->user->notify(new ThreadWasUpdated($this,$reply));
            }
        }
        */

        return $reply;

    }

    public function lock()
    {
        $this->update( ['locked' => true]);
        return $this;
    }

    public function notifySubscribers($reply)
    {
        $this->subscriptions
            ->where('user_id','!=',$reply->user_id)
            ->each
            ->notify($reply);
    }

    /**
     * A thread belongs to a creator
     * @return [type] [description]
     */
    public function creator()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

    /**
     * A thread belongs to a channel
     * @return [type] [description]
     */
    public function channel()
    {
        return $this->belongsTo(ForumChannel::class);
    }

    /**
     * [filter description]
     * @return [type] [description]
     */
    public function scopefilter($query,$filters)
    {
        return $filters->apply($query);

    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()
            ->create([
                'user_id'=>$userId?: auth()->id()
            ]);
        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where([
                'user_id'=>$userId?: auth()->id()
            ])
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id',auth()->id())
            ->exists();
    }


    public function hasUpdatesFor($user = null)
    {
        //Look in the cache for the proper key.
        //compare that carbon instance with the $thread->updated_at

        //$key = sprintf("user.%s.visit.%s",auth()->id(),$this->id);
        $user = $user ?: auth()->user();
        $key = $user->visitedThreadCacheKey($this);
        //

        return $this->updated_at > cache($key);
    }

    public function visits()
    {
        return new Visits($this);
    }


    public  function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the proper slug Attribute //mutator
     * @param $string $value
     */
    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);
        //$original = $slug;

        if(static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function markAsBestReply(Reply $reply)
    {
        //$this->update(['best_reply_id'=>$reply->id]);
        $this->best_reply_id = $reply->id;
        $this->save();
    }

}
