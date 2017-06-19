<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    //
    protected $fillable = [
    	'title',
    	'slug',
    	'color',
    ];


    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
