<?php

namespace Tests\Unit;

use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function a_channel_cconsists_a_threads()
    {
    	$channel = create('App\Channel');
    	$thread = create('App\Thread',['channel_id'=>$channel->id]);
    	//echo 'channel_id:'.$channel->id."\n";
        //dd($channel->threads);
    	$this->assertTrue($channel->threads->contains($thread));

    }

    /** @test */
    public function a_cahnnel_can_be_archived()
    {
        $channel = create('App\Channel');

        $this->assertFalse($channel->archived);
        
        $channel->archive();

        $this->assertTrue($channel->archived);
        
    }


    /** @test */
    public function archievd_channels_are_excluded_by_default()
    {
        create('App\Channel');

        create('App\Channel',['archived'=>true]);

        $this->assertEquals(1,Channel::count());
    }
}
