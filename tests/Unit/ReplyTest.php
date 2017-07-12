<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function it_has_a_owner()
    {
    	$reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User',$reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_test()
    {
        $reply  = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $reply->save();

        $this->assertFalse($reply->wasJustPublished());
    }


    /** @test */
    public function it_can_detect_all_mentioned_user_in_the_body()
    {
        $reply = create('App\Reply',[
            'body'=>'@JaneDoe wants to talk to @JohnDoe'
        ]);
        $mentionedUsers=$reply->mentionedUsers();
        $this->assertEquals(['JaneDoe','JohnDoe'],$mentionedUsers);
    }

    /** @test */
    public function it_wraps_mentionsed_usernames_in_the_body_within_anchor_tags()
    {
        $reply = create('App\Reply',[
            'body'=>'Hello @JaneDoe.'
        ]);
        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.', 
        $reply->body);
    }
}
