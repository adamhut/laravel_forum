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

    /** @test */
    public function it_knows_if_it_is_the_best_reply()
    {
        $reply = create('App\Reply');
        $this->assertFalse($reply->isBest());
        $reply->thread->update(['best_reply_id'=>$reply->id]);
        $this->assertTrue($reply->fresh()->isBest());

    }


    /** @test */
    public function a_reply_body_is_santized_automatically()
    {
        $reply = make('App\Reply', ['body' => '<script>alert("bad")</script><p>This is ok</p>']);

        $this->assertEquals('<p>This is ok</p>', $reply->body);
    }

    /** @test */
    public function it_generate_the_correct_path_for_a_paginated_thread ()
    {
        //give we have a thread
        $thread = create('App\Thread');
        //and that thread has three replies
        $replies = create('App\Reply',['thread_id'=>$thread->id],3);

        //and we are paginating 1 per page
        config(['council.pagination.perPage'=>1]);

        //if we generate the path for the last reply (3rd one)
        $replies->last()->path();

        //it shuld includ ?page -3 in the path
        $this->assertEquals(
            $thread->path().'?page=1#reply-3',
            $replies->faist()->path()
        );


        $this->assertEquals(
            $thread->path() . '?page=2#reply-3',
            $replies[1]->path()
        );

        $this->assertEquals(
            $thread->path() . '?page=3#reply-3',
            $replies->last()->path()
        );
    }
}
