<?php

namespace App;

use App\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Channel extends Model
{
    //
    protected $guarded = [];


    protected $casts=[
        'archived' =>'boolean'
    ];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active',function(Builder $builder){
            $builder->where('archived',false)
                ->orderBy('name', 'asc');
        });

        
       
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the name of the channel.
     *
     * @param string $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = str_slug($name);
    }


    public function archive()
    {
        $this->update(['archived'=>true]);
    }
}
