<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInFourmTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test*/
    public function a_unauthticated_user_may_not_add_replies()
    {
    	
    	$this->expectException('Illuminate\Auth\AuthenticationException');
    	
    	$this->post('/threads/1/replies',[]);	 
    	

    }

    /** @test */
    public function an_authenticated_user_may_participate_in_fourm_threads()
    {
    	//Give a authenticated user
    	$user = factory('App\User')->create();
    	$this->be($user);

    	//And an existing thread
    	$thread = factory('App\Thread')->create();
    	
    	//When the user adds a reply to the thread
    	$reply = factory('App\Reply')->make();

    	// /dd($reply);

    	$this->post($thread->path().'/replies',$reply->toArray());	 
    	
    	//Then their reply should be visible on the page
    	$this->get($thread->path())
    		->assertSee($reply->body);
    }
}
