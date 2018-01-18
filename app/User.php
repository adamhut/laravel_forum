<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'confirmation_token', 'confirmed', 'reputation',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    /**
     * get route key name for Laravel.
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function isTrusted()
    {
        return (bool) $this->trusted;
    }

    public function votes()
    {
        return $this->belongsToMany(CommunityLink::class, 'community_links_votes')
                    ->withTimestamps();
    }

    /*
    public function voteFor(CommunityLink $link)
    {
       // return $link->votes()->create(['user_id'=>$this->id]);
        return $link->votes()->toggle(['user_id'=>$this->id]);
    }
    */
    public function votedFor(CommunityLink $link)
    {
        return $link->contains('user_id', $this->id);
    }

    /**
     * get User threads.
     * @return [type] [description]
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function isAdmin()
    {
        return  $this->type == 'admin';
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function visitedThreadCacheKey($thread)
    {
        //dd($thread->id);
        return sprintf('user.%s.visit.%s', $this->id, $thread->id);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function avatar()
    {
        if (! $this->avatar_path) {
            return asset('/images/avatars/default.png');
        }

        return asset('/storage/'.$this->avatar_path);
    }

    /**
     * Get the path to the user's avatar.
     *
     * @param  string $avatar
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? '/storage/'.$avatar : 'images/avatars/default.png');
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();

        return $this;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
