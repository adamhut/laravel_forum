<?php

namespace App;


use App\ForumChannel;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    //
    use RecordActivity;

    protected $guarded =[];

    protected $with=['creator','channel'];

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
}
