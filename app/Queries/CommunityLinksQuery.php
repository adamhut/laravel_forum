<?php

namespace App\Queries;

use App\CommunityLink;

class CommunityLinksQuery
{
    public function get($sortByPopular, $channel)
    {
        $orderBy = $sortByPopular ? 'votes_count' : 'updated_at';

        /*
        return CommunityLink::with('votes','creator','channel')//eager loading the vote
            ->forChannel($channel)
            ->where('approved',1)
            ->leftJoin('community_links_votes','community_links_votes.community_link_id','=','community_links.id')
            ->selectRaw(
                'community_links.* ,count(community_links_votes.id) as vote_count'
            )
            ->groupBy('community_links.id')
            ->orderBy($orderBy,'desc')
            ->paginate(5);
            */

        return CommunityLink::with('creator', 'channel')//eager loading the vote
            ->withCount('votes')
            ->forChannel($channel)
            ->where('approved', 1)
            ->orderBy($orderBy, 'desc')
            ->paginate(5);
    }
}
