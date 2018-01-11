<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Reputation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_earn_points_when_they_craete_a_thread()
    {
        $thread = create('App\Thread');

        $this->assertEquals(Reputation::THREAD_WAS_PUBLISHED,$thread->creator->reputation);
    }

    /** @test */
    public function a_user_lose_points_when_they_craete_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id'=>auth()->id()]);

        $this->assertEquals(Reputation::THREAD_WAS_PUBLISHED, $thread->creator->reputation);

        $this->delete($thread->path());

        //you should lost the point
        self::assertEquals(0, $thread->creator->fresh()->reputation);
        $this->assertEquals(0, $thread->creator->fresh()->reputation);
    }


    /** @test */
    public function a_user_earns_points_when_they_reply_to_a_thread()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply([
            'user_id'   =>  create('App\User')->id,
            'body'      =>  'Here is the Reply',
        ]);
       

        $this->assertEquals(Reputation::REPLY_POSTED, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_their_reply_to_thread_is_deleted()
    {
        $this->signIn();

        $reply=create('App\Reply',['user_id'=>auth()->id()]);

        $this->assertEquals(Reputation::REPLY_POSTED, $reply->owner->reputation);

        $this->delete("replies/{$reply->id}");

        $this->assertEquals(0, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_their_reply_is_marked_as_best()
    {
        $thread = create('App\Thread');
        
        $reply = $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Here is the Reply',
        ]);

        $thread->markAsBestReply($reply);

        $this->assertEquals(Reputation::REPLY_POSTED + Reputation::BEST_REPLY_AWARDED, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_their_reply_is_marked_as_best_is_deleted()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Here is the Reply',
        ]);

        $thread->markAsBestReply($reply);

        $this->assertEquals(Reputation::REPLY_POSTED + Reputation::BEST_REPLY_AWARDED, $reply->owner->reputation);
    }


    /** @test */
    public function a_user_earns_points_when_their_reply_is_favorite()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = $thread->addReply([
            'user_id' =>auth()->id(),
            'body' => 'Here is the Reply',
        ]);
        
        $this->post("/replies/{$reply->id}/favorites");

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED;

        $this->assertEquals($total , $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_their_favorite_reply_is_unfavorited()
    {
        $this->signIn();

        $reply = create('App\Reply',['user_id'=>auth()->id()]);

        $this->post("replies/{$reply->id}/favorites");

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED;

        $this->assertEquals($total, $reply->owner->fresh()->reputation);

        $this->delete("replies/{$reply->id}/favorites");

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED - Reputation::REPLY_FAVORITED;

        $this->assertEquals($total, $reply->owner->fresh()->reputation);
    }

   

    

    
}
