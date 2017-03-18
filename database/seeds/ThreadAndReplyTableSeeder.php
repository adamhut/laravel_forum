<?php

use App\User;
use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class ThreadAndReplyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	User::truncate();
    	Reply::truncate();
    	Thread::truncate();
        //
        $threads = factory('App\Thread',50)->create();
        $threads->each(function($thread){
        	factory('App\Reply',10)->create([
        		'thread_id' =>$thread->id
        	]);
        });
    }
}
