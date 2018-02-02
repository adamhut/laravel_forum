<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
	use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    function a_thread_has_a_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->slug}", $thread->path()
        );
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->thread->replies
        );
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notify_all_register_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn();

        $this->thread->subscribe();

        $this->thread
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 999
            ]);

        Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);


    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }


    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        //Give  we have a thread
        $thread = create('App\Thread');

        //and  a authenticated user
       // $this->signIn();

        //wehen the suer subscribes to the thread

        $thread->subscribe($userId = 1);


        //then we shoudl be able to fetch all thread that the user has subscribed to
        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id',$userId)->count()
        );

    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        //Give  we have a thread
        $thread = create('App\Thread');

        //and  a authenticated user
       // $this->signIn();

        //wehen the suer subscribes to the thread

        $thread->subscribe($userId = 1);

        //then we shoudl be able to fetch all thread that the user has subscribed to
        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id',$userId)->count()
        );

        $thread->unsubscribe($userId = 1);

        //then we shoudl be able to fetch all thread that the user has subscribed to
        $this->assertEquals(
            0,
            $thread->subscriptions()->where('user_id',$userId)->count()
        );

    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        //Give  we have a thread
        $thread = create('App\Thread');

        //and  a authenticated user
        $this->signIn();


        $this->assertFalse($thread->isSubscribedTo);

        //wehen the suer subscribes to the thread
        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

    }

    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        //Give a authenticated user
        $this->signIn();

        //  we have a thread
        $thread = create('App\Thread');
       // dd($thread->id);
        $user = auth()->user();
        $this->assertTrue($thread->hasUpdatesFor($user));

        //Record that the user visited this page.
       // $key = sprintf("user.%s.visit.%s",auth()->id(),$thread->id);
        //Record the timestamp when they do so.
        //simulate that the user visited the thread
        $user->read($thread);

        $this->assertFalse($thread->hasUpdatesFor($user));
    }

    /** @test */
    public function a_thread_record_each_visit()
    {
        //Give a authenticated user
        $this->signIn();

        //  we have a thread
        $thread = make('App\Thread',['id'=>1]);
        $thread->visits()->reset();
        $this->assertSame(0, $thread->visits()->count());

        $thread->visits()->record(); //incr 100 to 101
        $this->assertEquals(1, $thread->visits()->count());

        $thread->visits()->record(); //incr 100 to 101
        $this->assertEquals(2, $thread->visits()->count());
        return;

        $this->assertSame(0, $thread->visits());

        $thread->recordVisit(); //incr 100 to 101
        $this->assertEquals(1, $thread->visits());

        $thread->recordVisit(); //incr 100 to 101
        $this->assertEquals(2, $thread->visits());
    }


    /** @test */
    public function a_thread_body_is_santized_automatically()
    {
        $thread = make('App\Thread', ['body'=>'<script>alert("bad")</script><p>This is ok</p>']);

        $this->assertEquals('<p>This is ok</p>',$thread->body);
    }
    
}
