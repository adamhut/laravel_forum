<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LockThreadTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function non_administrator_may_not_lock_threads()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread',['user_id'=>auth()->id()]);

        //hit an endpoint, that will update the locked attribute to true for the thread
        $this->post(route('locked-threads.store',$thread))->assertStatus(403);

        $this->assertFalse(!!$thread->fresh()->locked);
    }

     /** @test */
    public function an_administrator_may_not_lock_threads()
    {
        $this->withExceptionHandling();
        $this->signIn(factory('App\User')->states('admin')->create());

        $thread = create('App\Thread',['user_id'=>auth()->id()]);

        //hit an endpoint, that will update the locked attribute to true for the thread
        $this->post(route('locked-threads.store',$thread));

        $this->assertTrue(!!$thread->fresh()->locked,'Failed asserting that that the thread was lock');
    }

    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread');

        $thread->lock();

        $response = $this->post($thread->path().'/replies',[
            'body'      =>  'foobar',
            'user_id'   => auth()->user()->id,
        ])->assertStatus(422);
    }



}
