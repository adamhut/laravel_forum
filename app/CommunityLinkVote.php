<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

Class CommunityLinkVote extends Model
{
	protected $fillable=['user_id','community_link_id'];

	protected $table = 'community_links_votes';


	/*
	public function toggle()
	{
		 if($this->exists){
            $this->delete();
        }else
        {
            $this->save();
        }
        return $this;
	}
	*/
}