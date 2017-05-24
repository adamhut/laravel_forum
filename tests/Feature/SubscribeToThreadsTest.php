<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribeToThreadsTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads(){
    	$this->signIn();

    	//given we have a thread
    	$thread = create('App\Thread');

    	//and the user subscribes to the thread
    	$this->post($thread->path().'/subscriptions');

        $this->assertCount(1,$thread->fresh()->subscriptions);

    	
    	//$this->asserCount(1,auth()->user->notifications);
    	
    }

     /** @test */
    public function a_user_can_unsubscribe_from_threads(){
        $this->signIn();

        //given we have a thread
        $thread = create('App\Thread');

        //and the user subscribes to the thread
        $thread->subscribe();
        //then each time a new reply is left
        $this->assertCount(1,$thread->subscriptions);
        //and the user unsubscribes from the thread
        $this->delete($thread->path().'/subscriptions');
        
        $this->assertCount(0,$thread->fresh()->subscriptions);
       /* 
        
        $thread->addReply([
            'user_id'=>auth()->id(),
            'body' => 'some reply',
        ]);
        */

        //a notification should be prepare for the user
        //$this->asserCount(1,auth()->user->notifications);
        
    }

}
