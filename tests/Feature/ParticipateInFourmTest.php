<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInFourmTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test*/
    public function a_unauthticated_user_may_not_add_replies()
    {
    	
    	 $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');	 
    	

    }

    /** @test */
    public function an_authenticated_user_may_participate_in_fourm_threads()
    {
    	//Give a authenticated user
        $this->signIn();

    	//And an existing thread
    	$thread = create('App\Thread');
    	
    	//When the user adds a reply to the thread
    	$reply = make('App\Reply');

    	// /dd($reply);
    	$this->post($thread->path().'/replies',$reply->toArray());	 
    	
    	//Then their reply should be visible on the page
    	$this->get($thread->path())
    		->assertSee($reply->body);
    }

    /** @test */
    function a_reply_required_to_have_body()
    {
       $this->withExceptionHandling()->signIn();
       $thread = create('App\Thread');
        
        //When the user adds a reply to the thread
        $reply = make('App\Reply',['body'=>null]);
        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');     
    
    }
}
