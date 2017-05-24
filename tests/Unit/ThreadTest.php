<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
	use DatabaseMigrations;
    protected $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path()
        );
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->thread->replies
        );
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\ForumChannel', $thread->channel);
    }


    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        //Give  we have a thread
        $thread = create('App\Thread');
        
        //and  a authenticated user
       // $this->signIn(); 
        
        //wehen the suer subscribes to the thread
        
        $thread->subscribe($userId = 1);


        //then we shoudl be able to fetch all thread that the user has subscribed to 
        $this->assertEquals(
            1, 
            $thread->subscriptions()->where('user_id',$userId)->count()
        );
        
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        //Give  we have a thread
        $thread = create('App\Thread');
        
        //and  a authenticated user
       // $this->signIn(); 
        
        //wehen the suer subscribes to the thread
        
        $thread->subscribe($userId = 1);

        //then we shoudl be able to fetch all thread that the user has subscribed to 
        $this->assertEquals(
            1, 
            $thread->subscriptions()->where('user_id',$userId)->count()
        );

        $thread->unsubscribe($userId = 1);
        
        //then we shoudl be able to fetch all thread that the user has subscribed to 
        $this->assertEquals(
            0, 
            $thread->subscriptions()->where('user_id',$userId)->count()
        );

    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        //Give  we have a thread
        $thread = create('App\Thread');
        
        //and  a authenticated user
        $this->signIn(); 

        
        $this->assertFalse($thread->isSubscribedTo); 

        //wehen the suer subscribes to the thread
        $thread->subscribe();  

        $this->assertTrue($thread->isSubscribedTo);

    }

    

   
}
