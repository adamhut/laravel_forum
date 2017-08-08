<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function only_member_can_add_avatar()
    {
    	//401 
    	$this->withExceptionHandling();

    	$this->json('POST','api/users/1/avatar')
    		->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
    	$this->withExceptionHandling()->signIn();

    	$this->json('POST','api/users/',auth()->id().'/avatar',[
    		'avatar'=>'not-an-image'
    	])->assertStatus(422);
    	//422 unprocessorable enitity
    }

    /** @test */
    public function a_user_may_add_avatar_to_their_profile()
    {
    	$this->signIn();

    	Storage::fake('public');
		//dd(UploadedFile::fake()->image('avatar.jpg'));
    	$this->json('POST','api/users/',auth()->id().'/avatar',[

    		'avatar'=> $file = UploadedFile::fake()->image('avatar.jpg')
    	]);

    	$this->assertEquals('avatars/'.$file->hashName(),auth()->user()->avatar_path);

    	Storage::disk('public')->assertExists('avatars/'.$file->hashName());
    	//422 unprocessorable enitity
    }
}