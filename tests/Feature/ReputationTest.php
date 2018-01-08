<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_earn_points_when_they_craete_a_thread()
    {
        $thread = create('App\Thread');

        $this->assertEquals(10,$thread->creator->reputation);
    }


    /** @test */
    public function a_user_earns_points_when_they_reply_to_a_thread()
    {
        $thread = create('App\Thread');
        $reply = $thread->addReply([
            'user_id'   =>  create('App\User'),
            'body'      =>  'Here is the Reply',
        ]);

        $this->assertEquals(2, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_earns_points_when_their_reply_is_marked_as_best()
    {
        $thread = create('App\Thread');
        $reply = $thread->addReply([
            'user_id' => create('App\User'),
            'body' => 'Here is the Reply',
        ]);

        $thread->markBestReply($reply);

        $this->assertEquals(2+50, $reply->owner->reputation);
    }
}
