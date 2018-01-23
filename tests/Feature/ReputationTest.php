<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Reputation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    protected $points;

    public function setUp()
    {
        parent::setUp();

        $this->points = config('council.reputation');
    }

    /** @test */
    public function a_user_earn_points_when_they_craete_a_thread()
    {
        $thread = create('App\Thread');

        $this->assertEquals($this->points['thread_published'],$thread->creator->points);
        //dd($thread->creator->reputation);
    }

    /** @test */
    public function a_user_lose_points_when_they_craete_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id'=>auth()->id()]);

        $this->assertEquals($this->points['thread_published'], $thread->creator->points);

        $this->delete($thread->path());

        //you should lost the point
        self::assertEquals(0, $thread->creator->fresh()->points);
        $this->assertEquals(0, $thread->creator->fresh()->points);
    }


    /** @test */
    public function a_user_earns_points_when_they_reply_to_a_thread()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply([
            'user_id'   =>  create('App\User')->id,
            'body'      =>  'Here is the Reply',
        ]);
       

        $this->assertEquals($this->points['reply_posted'], $reply->owner->points);
    }

    /** @test */
    public function a_user_loses_points_when_their_reply_to_thread_is_deleted()
    {
        $this->signIn();

        $reply=create('App\Reply',['user_id'=>auth()->id()]);

        $this->assertEquals($this->points['reply_posted'], $reply->owner->points);

        $this->delete("replies/{$reply->id}");

        $this->assertEquals(0, $reply->owner->fresh()->points);
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

        $this->assertEquals($this->points['reply_posted'] + $this->points['best_reply_awarded'] , $reply->owner->points);
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

        $this->assertEquals($this->points['reply_posted'] + $this->points['best_reply_awarded'], $reply->owner->points);
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
        $this->assertEquals($this->points['reply_posted'] , $reply->owner->fresh()->points);
        //return ;

        //and John favorite that reply
        $this->post(route('replies.favorite',$reply->id));

        $total = $this->points['reply_posted'] + $this->points['reply_favorited'];

        //then Jane's Reputation should grow, accordingly
        $this->assertEquals($total , $jane->fresh()->points);

        //while John's should remain unaffected
        $this->assertEquals(0, $john->fresh()->points);
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
        $total = $this->points['reply_posted'] + $this->points['reply_favorited'];
        $this->assertEquals($total, $jane->fresh()->points);

        //But ,if John unfavorite that reply
        $this->delete(route('replies.favorite', $reply->id));

        //then Jane's Reputation should reduce accordingly
        $total = $this->points['reply_posted'] + $this->points['reply_favorited'] - $this->points['reply_favorited'];
        $this->assertEquals($total, $reply->owner->fresh()->points);

        //while John's should remain unaffected
        $this->assertEquals(0, $john->fresh()->points);
    }    
}
