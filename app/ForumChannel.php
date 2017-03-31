<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

class ForumChannel extends Model
{
    //
    protected $guarded=[];


    public function threads()
    {
    	return $this->hasMany(Thread::class,'channel_id');
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
