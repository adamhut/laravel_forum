<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MentionUsersTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    public function mention_users_in_a_reply_are_notified()
    {

    	//given I have a user JohnDoe who is signed in
    	$john = create('App\User',['name'=>'JohnDoe']);
    	$this->signIn($john);
    	//And another user JeanDoe
    	$jane = create('App\User',['name'=>'JaneDoe']);
    	
    	//if we have a tread
    	$thread = create('App\Thread');
    	//and JohnDoe replies and mention @JaneDoe
    	$reply  = make('App\Reply',[
    		'body'=>'hello @JaneDoe look at this'
    	]);
    	 $this->json('post',$thread->path().'/replies',$reply->toArray());
    	//Then JaneDoe Should be Notified
    	
    	$this->assertCount(1,$jane->notifications);
    	
    }

    /** @test */
    public function it_can_detch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User',['name'=>'johndoe']);
        create('App\User',['name'=>'janedoe']);
        create('App\User',['name'=>'johndoe2']);
        
        $result = $this->json('GET','/api/users',['name'=>'john']);

        $this->assertCount(2,$result->json());
    }
}
