<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations , DatabaseTransactions;
    
   /// protected $thread;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function setUp()
    {
        parent::setUp();
        $this->thread= factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        //$thread= factory('App\Thread')->create();
        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);  
    }



    /** @test */
    public function a_user_can_read_replies_that_are_assoicated_with_a_thread()
    {
        //Give we have thread 
        //and that thread includes replies 
        $reply = factory('App\Reply')->create([
            'thread_id' =>$this->thread->id
        ]);
        //when we visit a thread page
        $response = $this->get('/threads/' . $this->thread->id);
        //then we should see the replies
        $response->assertSee($reply->body);
    }
    
}
