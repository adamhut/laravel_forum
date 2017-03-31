<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function a_channel_cconsists_a_threads()
    {
    	$channel = create('App\ForumChannel');
    	$thread = create('App\Thread',['channel_id'=>$channel->id]);
    	//echo 'channel_id:'.$channel->id."\n";
        //dd($channel->threads);
    	$this->assertTrue($channel->threads->contains($thread));

    }
}
