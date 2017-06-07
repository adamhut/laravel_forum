<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImpersonateUsersTest extends TestCase
{
   
    use DatabaseTransactions;

    /** @test */
    public function non_admins_cannot_impersonate_users()
    {
    	$user = factory('App\User')->create();
    	
    	$this->get(route('impersonate',$user))
    		->assertRedirect('login');
		return;
    	$this->actingAs($user);

    	$this->get(route('impersonate',$user))
    		->assertStatus(403);
    }

     /** @test */
    public function admin_can_impersonate_users()
    {
    	$admin = factory('App\User')->states('admin')->create();	
    	$user = factory('App\User')->create();

    	$this->actingAs($admin);

    	$this->get(route('impersonate',$user))
    		->assertEquals(auth()->user()->id,$user->id);

    }
}
