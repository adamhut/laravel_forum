<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
	use DatabaseTransactions;
   

	/** @test */
    function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')
            ->assertRedirect('/login');
        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        //dd($thread->path());
        //$this->get($thread->path())
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

 
    /** @test */
    function a_thread_requires_a_title()
    {
            
        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');
        
        /*$thread = make('App\Thread',['title'=>null]);
        //dd($thread);
        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('title');
        */
    }

    /** @test */
    function a_thread_requires_a_body()
    {
            
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel',2)->create();
        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id'=>-1])
            ->assertSessionHasErrors('channel_id');
    
    }


    
    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
