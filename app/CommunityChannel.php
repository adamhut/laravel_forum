<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityChannel extends Model
{
    //
    protected $fillable = [
        'title',
        'slug',
        'color',
        'description',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class, 'channel_id');
    }
}
