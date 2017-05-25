<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
    {
        parent::setUp();
        $this->signIn();
    }

	/** @test */
	public function a_notifcation_is_prepared_when_a_subscribed_thread_receives_a_new_reply_is_not_by_current_user()
	{
	

    	//given we have a thread
    	$thread = create('App\Thread')->subscribe();

    	//and the user subscribes to the thread
    	//$this->post($thread->path().'/subscriptions');
		//then each time a new reply is left
    	//$this->assertCount(1,$thread->subscriptions);
        $this->assertCount(0,auth()->user()->notifications);


    	$thread->addReply([
    		'user_id'=>auth()->id(),
    		'body' => 'some reply',
    	]);
    	/**/

    	//a notification  should be prepare for the user
        //
        $this->assertCount(0,auth()->user()->fresh()->notifications);

        $thread->addReply([
    		'user_id'=> create('App\User')->id,
    		'body' => 'some reply',
    	]);
    	 $this->assertCount(1,auth()->user()->fresh()->notifications);
	}

	/** @test */
	public function a_user_can_fetch_their_unread_notifications()
	{
		create(DatabaseNotification::class);
		/*
		$thread = create('App\Thread')->subscribe();
    	$thread->addReply([
    		'user_id'=>create('App\User')->id,
    		'body' => 'some reply',
    	]);
    	*/
		$user = auth()->user();

    	$response = $this->getJson("profiles/{$user->name}/noticiations")->json();
    
    	$this->assertCount(1,$response);
	}

	/** @test */
	public function a_user_can_make_a_notification_as_read()
	{
		create(DatabaseNotification::class);

    	//given we have a thread
    	/*
    	$thread = create('App\Thread')->subscribe();

    	$thread->addReply([
    		'user_id'=>create('App\User')->id,
    		'body' => 'some reply',
    	]);
		*/
    	$user = auth()->user();

    	$this->assertCount(1,$user->unreadNotifications);
    	
    	$notificationId = $user->unreadNotifications->first()->id;	 
		
		$this->delete("profiles/{$user->name}/noticiations/{$notificationId}");

		$this->assertCount(0,$user->fresh()->unreadNotifications);

	}

}
