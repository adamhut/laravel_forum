<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
	use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->signIn();
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
    public function a_thread_requires_a_title_and_body_to_be_update()
    {
        $user = auth()->user();
        $thread = create('App\Thread',['user_id'=>$user->id]);

        $this->patch($thread->path(),[
            'title' => 'Changed', 
            
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(),[
            'body' => 'Changed Body', 
            
        ])->assertSessionHasErrors('title');

    }

    /** @test */
    public function unauthorized_users_may_not_update_thread()
    {
        $user = auth()->user();

        $thread = create('App\Thread',['user_id'=>create('App\User')->id]);

        $this->patch($thread->path(),[])->assertStatus(403);
    }

    /** @test */
    public function a_thread_can_be_updated_by_its_creator()
    {
        $user = auth()->user();

        $thread = create('App\Thread',['user_id'=>$user->id]);

        $this->patch($thread->path(),[
            'title' => 'Changed', 
            'body'  => 'Changed body',
        ]);

        tap($thread->fresh(),function($thread){
            $this->assertEquals('Changed', $thread->title);
            $this->assertEquals('Changed body', $thread->body);
        }); 



    }
}
