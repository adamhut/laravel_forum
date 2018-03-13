<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        //$m = \Mockery::mock(Recaptcha::class);
        //$m->shouldRecevie('passes')->once()->andReturn(true);
        //app()->singleton(Recaptcha::class,$m);
        //or
        app()->singleton(Recaptcha::class,function(){
            return \Mockery::mock(Recaptcha::class,function($m){

                $m->shouldRecevie('passes')->andReturn(true);
            });

            //$m->shouldRecevie('passes')->once()->andReturn(true);
        });


    }

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
    function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);
        $thread = make('App\Thread');
        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    /** @test */
    function a_user_user_can_create_new_forum_threads()
    {
        //$this->signIn();

        //$thread = make('App\Thread');

        //$response = $this->post('/threads', $thread->toArray()+['g-recaptcha-response'=>'token']);

        $response = $this->publishThread([
            'title' =>  'some title',
            'body'  =>  'some body',
        ]);

        //dd($thread->path());
        //$this->get($thread->path())
        $this->get($response->headers->get('Location'))
            ->assertSee('some title')
            ->assertSee('some body');
    }


    /** @test */
    function a_thread_requires_a_title()
    {
        $this->withExceptionHandling();
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
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);
        $this->publishThread(['g-recaptcha-response'=>'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
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
    function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create([
            'title' =>'foo title'
        ]);

        $this->assertEquals($thread->fresh()->slug,'foo-title');

        $thread = $this->postJson(route('threads'),$thread->toArray()+['g-recaptcha-response'=>'token'])->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = factory('App\Thread')->create([
            'title' =>'some title 24',
        ]);

        $thread = $this->postJson(route('threads'),$thread->toArray()+['g-recaptcha-response'=>'token'])->json();
        dd($thread);
        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
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

    /** @test */
    public function a_new_thread_cannot_be_created_in_an_archived_channel()
    {

        $channel = factory('App\Channel')->create(['archived' => true]);

        $this->publishThread(['channel_id' => $channel->id])
            ->assertSessionHasErrors('channel_id');
        
        $this->assertCount(0, $channel->threads);
    }


    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray()+['g-recaptcha-response'=>'token']);
    }
}
