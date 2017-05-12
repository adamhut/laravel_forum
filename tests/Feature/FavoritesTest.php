<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /** @test */
    public function guest_can_not_favorites_anything()
    {
    	$this->withExceptionHandling();
    	$this->post('replies/1/favorites')
    		->assertRedirect('/login');
    }

    /** @test */
    public function a_authenticated_user_can_favorite_any_reply()
    {
    	$this->signIn();
    	$reply = create('App\Reply');//this will also create a thread

    	//dd($reply->id);
    	//If I post to a favorite endpoint
    	$this->post('replies/'.$reply->id.'/favorites');
    	//it should be recorded in the database		
    	//dd(\App\favorite::all());
    	$this->assertCount(1,$reply->favorites);
    }

    /** @test */
    public function a_authenticated_user_may_only_favorite_a_reply_once()
    {
    	$this->signIn();
    	$reply = create('App\Reply');//this will also create a thread

    	//dd($reply->id);
    	try{
    		//If I post to a favorite endpoint
    		$this->post('replies/'.$reply->id.'/favorites');
    		$this->post('replies/'.$reply->id.'/favorites');
    	}catch(\Exception $e)
    	{
    		$this->fail('Did Not Except to insert a record twice');
    	}
    	//it should be recorded in the database		
    	//dd(\App\favorite::all()->toArray());
    	$this->assertCount(1,$reply->favorites);
    }

    /** @test */
    public function a_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');//this will also create a thread

        $this->post('replies/'.$reply->id.'/favorites');

        $this->assertCount(1,$reply->favorites);

        $this->delete('replies/'.$reply->id.'/favorites');

        $this->assertCount(0,$reply->fresh()->favorites);
    }

}
