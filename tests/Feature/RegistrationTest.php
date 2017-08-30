<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertSent(PleaseConfirmYourEmail::class);

    }

    /** @test */
    public function user_can_fully_confirm_their_email_addresses()
    {
        $this->post(route('register'),[
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar',
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse( $user->confirmed);

        $this->assertNotNull($user->confirmation_token);

        //let the user confirm their account

        $response = $this->get(route('register.confirm',['token'=>$user->confirmation_token]));

        tap($user->fresh(),function($user){
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });
        
        $response->assertRedirect(route('threads'));
    }


    /** @test */
    public function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm',['token' => 'invalid token']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash','Unknown Token.');
    }
}
