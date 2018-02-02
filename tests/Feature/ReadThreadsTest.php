<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        /*
        $this->get($this->thread->path())
            ->assertSee($reply->body);
            */
    }


    /** @test */
    function a_user_can_filter_threads_accoutding_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel =  create('App\Thread',['channel_id'=>$channel->id]);
        $threadNotInChannel =  create('App\Thread');

        $this->get("threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);

    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->SignIn(create('App\User',['name'=>'JohnDoe']));
        $threadByJohn = create('App\Thread',['user_id'=>auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);
        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);
        $threadWithNoReplies = $this->thread;
        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 1);

        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function a_user_request_all_replies_for_a_give_thread()
    {
        $thread=create('App\Thread');
        create('App\Reply',['thread_id'=>$thread->id],2);

        $response = $this->getJson($thread->path().'/replies')->json();
        $this->assertCount(1, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    /** @test */
    public function we_record_a_new_visit_each_time_the_thread_is_read()
    {
        $thread=create('App\Thread');

        $this->assertSame(0,$thread->visits()->count());

        $this->call('GET',$thead->path());

        $this->assertEquals(1,$thread->visits()->count());
    }
}
