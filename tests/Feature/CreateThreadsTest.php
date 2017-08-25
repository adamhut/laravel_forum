<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;
   

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
    public function authenticated_user_must_first_confirm_their_email_address_before_create_thread()
    {
        $this->publishThread()
            ->assertRedirect('/threads')
            ->assertSessionHas('flash','You must first confirm your email address');
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

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');
        //dd($thread->path());
       // $this->json('DELETE',$thread->path())->assertStatus(401);
        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
        //$this->json('DELETE',$thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id'=>auth()->id()]);
        $reply= create('App\Reply',['thread_id'=>$thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',['id'=>$thread->id]);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
        
        $this->assertDatabaseMissing('activities',[
            'subject_id'  =>$thread->id,
            'subject_type'  => get_class($thread)
        ]);

         $this->assertDatabaseMissing('activities',[
            'subject_id'  =>$reply->id,
            'subject_type'  => get_class($reply)
        ]);
        $this->assertEquals(0, \App\Activity::count());

    }

   
    
    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
