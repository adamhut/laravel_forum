<?php

namespace App;


use App\ForumChannel;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    //
    use RecordActivity;

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
        */
        static::deleting(function($thread){
            $thread->replies()->each(function($reply){
                $reply->delete();
            });
        });

        /* move to RecordActivity trait
        static::created(function($thread){
            $thread->recordActivity('create');
        });
        */
    } 
  

    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        //return $this->hasMany(Reply::class)->withCount('favorites');

        //load the reply with the favorites count
    	return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
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
        $reply =  $this->replies()->create($reply);

        //$this->increment('replies_count');
        
        //prepare all notification to all subscribers.
        //
        $this->subscriptions
            ->filter(function($subscription) use ($reply){
                return $subscription->user_id != $reply->user_id;
            })
            ->each->notify($reply);
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

}
