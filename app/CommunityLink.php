<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CommunityLinkAlreadySubmitted;

class CommunityLink extends Model
{
    //
    protected $fillable = [
        'channel_id',

        'title',
        'url',
    ];
    protected $guarded = [];

    //
    public static function from(User $user)
    {
        $link = new static;
        $link->user_id = $user->id;
        if ($user->isTrusted()) {
            $link->approve();
        }

        /*
        if($user->isPreApproved)
        {
            $link->approved = true;
        }
        */

        return $link;
    }

    /**
     * A communuity link has a createor.
     *
     * @return
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * contribututed the given community link.
     * @param  array $attributes [description]
     * @return bool             [description]
     * @throws CommunityLinkAlreadySubmitted
     */
    public function contribute($attributes)
    {
        //
        if ($existing = $this->hasAlreadyBeenSubmitted($attributes['url'])) {
            //dd($existing);
            $existing->touch();
            throw new CommunityLinkAlreadySubmitted;
        }

        return $this->fill($attributes)->save();
    }

    /**
     * Mark the community link is approved.
     * @return $this
     */
    public function approve()
    {
        $this->approved = 1;

        return $this;
    }

    public function channel()
    {
        return $this->belongsTo(channel::class, 'channel_id');
    }

    /**
     * A community link may have many votes.
     * @return CommunityLinkVote
     */
    public function votes()
    {
        //return $this->hasMany(CommunityLinkVote::class,'community_link_id');
        return $this->belongsToMany(User::class, 'community_links_votes')
                    ->withTimestamps();
    }

    /**
     * determent if the link has already been submiited.
     * @param  string  $url [description]
     * @return bool      [description]
     */
    protected function hasAlreadyBeenSubmitted($url)
    {
        return static::where('url', $url)->first();
    }

    /**
     * Scrope the query to recrods for a particular channel.
     * @param   $builder [description]
     * @param  App\Channel $channel [description]
     * @return [type]          [description]
     */
    public function scopeForChannel($builder, $channel)
    {
        if ($channel->exists) {
            return  $builder->where('channel_id', $channel->id);
        }

        return $builder;
    }
}
