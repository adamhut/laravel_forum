<?php

namespace App\Http\Controllers;

use App\Channel;
use App\CommunityLink;
use Illuminate\Http\Request;
use App\Queries\CommunityLinksQuery;
use App\Http\Requests\CommunityLinkForm;
use App\Exceptions\CommunityLinkAlreadySubmitted;

class CommunityLinksController extends Controller
{
    //
    public function index(Channel $channel = null)
    {
        $links = (new CommunityLinksQuery)->get(
            request()->exists('popular'), $channel
        );
        /*
        $links = CommunityLink::with('votes','creator','channel')//eager loading the vote
            ->forChannel($channel)
            ->where('approved',1)
            ->latest('updated_At')
            ->get();
            //->paginate(2);

        $links = $links->sortByDesc(function($link){
            return $link->votes()->count();
        });
        */
        /*
         $links = CommunityLink::with('votes','creator','channel')//eager loading the vote
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
        // / dd($links);

        $channels = Channel::orderBy('title', 'asc')->get();

        return view('community.index', compact('channels', 'links', 'channel'));
    }

    public function store(CommunityLinkForm $form)
    {
        /*
    	$this->validate($request,[
    		'channel_id' => 'required|exists:channels,id',
    		'title' =>	'required',
    		'url'	=>	'required|active_url',
    	]);
    	*/
        //$user_id = auth()->user()->id;
        //CommunityLink::create($request->all());

        $form->persist();
        //Move it to the form object
        /*try{
            CommunityLink::from(auth()->user())->contribute($request->all());
            if(auth()->user()->isTrusted())
            {
                flash('Thank for the contribution!','success');
            }else
            {
                flash()->overlay('Your contribution will be approved shortly','thanks');
            }
        }catch(CommunityLinkAlreadySubmitted $e){
            flash()->overlay('we will instead bump the timestamps and bring that link back to the top',
                'That link has already been submitted');

        }*/

        //flash('Thank for the contribution');

        return back();
    }
}
