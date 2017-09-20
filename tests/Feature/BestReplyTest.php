<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BestReplyTest extends TestCase
{
	use DatabaseMigrations;
    /** @test */
    public function a_thread_creator_may_make_any_reply_as_the_best_answer()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id'=>auth()->id()]);

        $replies = create('App\Reply',['thread_id'=>$thread->id],2);
        
        $this->assertFalse($replies[1]->isBest());

        $this->postJson(route('best-replies.store',[$replies[1]->id]));

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    /** @test */
    public function only_the_thread_may_mark_a_reply_as_best()
    {
    	$this->withExceptionHandling();

        $this->signIn();
        
        $thread = create('App\Thread',['user_id'=>auth()->id()]);

        $replies = create('App\Reply',['thread_id'=>$thread->id],2);
        
        $this->signIn(create('App\User'));

        $this->postJson(route('best-replies.store',[$replies[1]->id]))->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());

    }
}