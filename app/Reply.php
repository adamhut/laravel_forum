<?php

namespace App;

use App\User;
use App\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    

    use Favoritable, RecordActivity;
    
    protected $fillable=[
    	'body',
    	'user_id'
    ];

    protected $with=['owner', 'favorites'];

    protected $appends=['isFavorited', 'favoritesCount'];
    

    protected static function boot()
    {
        parent::boot();

        static::created(function($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function($reply){
            $reply->thread->decrement('replies_count');
        });
    }


    public function owner()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path()."#reply-{$this->id}";
    }
 
    

}
