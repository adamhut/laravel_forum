<?php

namespace App;


use App\ForumChannel;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    //
    protected $guarded =[];

    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

    public function addReply($reply)
    {
    	$this->replies()->create($reply);
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
