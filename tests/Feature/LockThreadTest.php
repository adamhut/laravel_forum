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
    public function a_administrator_can_lock_any_thread()
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
