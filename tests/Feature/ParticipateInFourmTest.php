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
        $this->assertDataBaseHas('replies',['body'=>$reply->body]);

        $this->assertEquals(1,$thread->fresh()->replies_count);
    	/*$this->get($thread->path())
    		->assertSee($reply->body);
            */
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

    /** @test */
    public function unauthorized_user_can_not_delete_replies()
    {
        $this->withExceptionHandling();
        
        $reply = create('App\Reply');
        
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_replies()
    {
        $this->signIn();
        
        $reply = create('App\Reply',['user_id'=>auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
        //dd($reply->thread->fresh()->replies_count);
        $this->assertEquals(0,$reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function authorized_user_can_update_replies()
    {
        $this->signIn();
        
        $updateText="You have been updated";
        $reply = create('App\Reply',['user_id'=>auth()->id()]);

        $this->patch("/replies/{$reply->id}",['body'=>$updateText]);//->assertStatus(302);
        $this->assertDatabaseHas('replies',['id'=>$reply->id,'body'=>$updateText]);
    }

    /** @test */
    public function unauthorized_user_can_not_update_replies()
    {
        $this->withExceptionHandling();
         $updateText="You have been updated";
        $reply = create('App\Reply');
        
        $this->patch("/replies/{$reply->id}",['body'=>$updateText])
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test*/
    public function replies_that_contain_spam_may_not_be_created()
    {
        //Give a authenticated user
        $this->signIn();

        //And an existing thread
        $thread = create('App\Thread');
        
        //When the user adds a reply to the thread
        $reply = make('App\Reply',[
            'body'=>'Yahoo Customer Support',
        ]);

        //$this->expectException(\Exception::class);

        // /dd($reply);
        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertStatus(422);  
        
    }

    /** @test */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    {
        //Give a authenticated user
        $this->signIn();

        //And an existing thread
        $thread = create('App\Thread');

        //When the user adds a reply to the thread
        $reply = make('App\Reply',[
            'body'=>'My Simple Reply',
        ]);

        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertStatus(200);  

         //When the user adds a reply to the thread
        $reply = make('App\Reply',[
            'body'=>'My Simple Reply again',
        ]);

        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertStatus(422);  
    }
}
