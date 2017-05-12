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
        $user=factory('App\User')->create([
                'name' => 'adamtest',
                'email' => 'ahuang@bacera.com',
                'password' => bcrypt('test0000'),
        ]);
        factory('App\Thread',10)->create(['user_id'=>$user->id]);
        
        $threads = factory('App\Thread',50)->create();
        $threads->each(function($thread){
            $times= mt_rand(1,30);
        	factory('App\Reply',$times)->create([
        		'thread_id' =>$thread->id
        	]);
        });
    }
}
