<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    
    use RefreshDatabase;
    
    
    /** @test */
    public function a_user_can_search_threads()
    {
        config(['scout.driver'=>'algolia']);

        $search  = 'foobar';

        create('App\Thread',[],2);

        $desiredThreads = create('App\Thread',['body' => "A thread with the {$search} terms."] ,2);
        
        do{
            sleep(.25);
            $results= $this->getJson("/threads/search?q={$search}")->json()['data'];
            
        }while(empty($results));

        $this->assertCount(2,$results);
        
        //$desiredThreads->unsearchable();
        
        Thread::latest()->take(4)->unsearchable();

    }

    
}
