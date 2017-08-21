<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseMigrations;
   /** @test */
   public function a_user_can_fetch_their_most_recent_reply()
   {
   		$user = create('App\User');

   		$reply = create('App\Reply',['user_id'=>$user->id]);

   		//$user->lastReply->id = $reply->id
   		$this->assertEquals($reply->id, $user->lastReply->id);
   }

   /** @test */
   public function a_user_can_determine_their_avatar_path()
   {
   		$user = create('App\User');

   		$this->assertEquals(asset('images/avatars/default.jpg'), $user->avatar_path);

   		$user->avatar_path ='avatars/me.jpg';

   		$this->assertEquals(asset('storage/avatars/me.jpg'), $user->avatar_path);
   }
}
