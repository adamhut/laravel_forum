<?php

namespace App;

use App\CommunityLink;
use App\CommunityLinkVote;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function isTrusted()
    {
        return !! $this->trusted;
    }

    public function votes()
    {
        return $this->belongsToMany(CommunityLink::class,'community_links_votes')
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
        return $link->contains('user_id',$this->id);
    }  

}
