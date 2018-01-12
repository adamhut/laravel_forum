<?php

namespace Tests\Feature;

//use App\Trending;
use App\Trending;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrendingThreadTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp()
	{
		parent::setUp();
		$this->trending  = new Trending();
		$this->trending->reset();

	}
    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read()
    {
    
       
        $this->assertEmpty(0,$this->trending->get());
    	
    	$thread = create('App\Thread');
        $this->call('GET',$thread->path());
 
        $trending = $this->trending->get();
        $this->assertCount(1, $trending);
        //dd($trending);
        $this->assertEquals($thread->title, $trending[0]->title);
    	
    }

    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read_by_homemade_fake()
    {
        app()->instance(Trending::class, new FakeTrending);

        $trending = app(Trending::class);
        $trending->assertEmpty();
        //dd($trending);

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $trending->assertCount(1);

        $this->assertEquals($thread->title, $trending->thread[0]->title);
    }

    
}

class FakeTrending extends Trending
{
    public $thread = [];

    public function push($thread)
    {
        $this->thread[] = $thread;
    }

    public function assertEmpty()
    {
        \PHPUnit\Framework\Assert::assertEmpty($this->thread);
    }

    public function assertCount($count)
    {
        \PHPUnit\Framework\Assert::assertCount($count,$this->thread);
    }
}