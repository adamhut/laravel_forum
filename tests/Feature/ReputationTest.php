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
    public function a_user_gains_points_when_their_reply_is_favorited()
    {
        //given we have a a signed in user John
        $this->signIn($john = create('App\User'));

        $thread = create('App\Thread');
        //and also Jane..
        $jane = create('App\User');

        //If Jane adds a new reply to a thread
        $reply = $thread->addReply([
            'user_id' => $jane->id,
            'body' => 'Here is the Reply',
        ]);
        $this->assertEquals(Reputation::REPLY_POSTED , $reply->owner->fresh()->reputation);
        //return ;

        //and John favorite that reply
        $this->post(route('replies.favorite',$reply->id));

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED;

        //then Jane's Reputation should grow, accordingly
        $this->assertEquals($total , $jane->fresh()->reputation);

        //while John's should remain unaffected
        $this->assertEquals(0, $john->fresh()->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_their_favorited_reply_is_unfavorited()
    {
        //Given we have a a signed in user, John
        $this->signIn($john = create('App\User'));
        
        //And also Jane..
        $jane = create('App\User');

        //If Jane add reply to that thread
        $reply = create('App\Reply',['user_id'=> $jane->id]);

        //And John favorite that reply
        $this->post(route('replies.favorite', $reply->id));

        //then Jane's Reputation should grow, accordingly
        $total = Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED;
        $this->assertEquals($total, $jane->fresh()->reputation);

        //But ,if John unfavorite that reply
        $this->delete(route('replies.favorite', $reply->id));

        //then Jane's Reputation should reduce accordingly
        $total = Reputation::REPLY_POSTED + Reputation::REPLY_FAVORITED - Reputation::REPLY_FAVORITED;
        $this->assertEquals($total, $reply->owner->fresh()->reputation);

        //while John's should remain unaffected
        $this->assertEquals(0, $john->fresh()->reputation);
    }    
}
