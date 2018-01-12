<?php

namespace Tests\Unit;

use App\Trending;
use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingTest extends TestCase
{
    use RefreshDatabase;

    public $trending;

    public function setUp()
    {
        parent::setUp();
        $this->trending = new Trending();
        $this->trending->reset();
        //$cacheKey= app()->environment('testing') ? 'testing_trending_threads' : 'trending_threads';
        //Redis::del($cacheKey);
    }

    /** @test */
    public function it_store_trending_thread_in_redis()
    {
        //$trending  = new Trending();
        // /$this->trending->reset();
        $this->assertEmpty($this->trending->get());

        //$this->trending->push(factory('App\Thread')->make());//read thread
        $this->trending->push(new FakeThread('Boring Thread'));//fake thread

        $this->trending->push(new FakeThread('Popular Thread'));//fake thread
        $this->trending->push(new FakeThread('Popular Thread'));//fake thread
        $this->trending->push(new FakeThread('Popular Thread'));//fake thread

       
        $this->assertCount(2, $trending = $this->trending->get());

      
        $this->assertEquals(['Popular Thread','Boring Thread'],array_pluck($trending,'title'));
    }

    

    
}

class FakeThread{
    public $title;

    public function __construct($title)
    {
        $this->title = $title;    
    }

    public function path()
    {
        return 'some/path';
    }
}
