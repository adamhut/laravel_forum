<?php

use App\User;
use App\Channel;
use App\CommunityLink;
use Illuminate\Database\Seeder;

class CommunityLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Channel::truncate();
        CommunityLink::truncate();
        $user1 = factory('App\User')->create([
            'name' => 'adam',
            'email' => 'ahuang@bacera.com',
            'password' => bcrypt('test0000'),
            'trusted' =>1,
        ]);
        factory('App\CommunityLink', 3)->create([
            'user_id'=>$user1->id,
            'approved'=>$user1->trusted,
        ]);

        $user2 = factory('App\User')->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('test0000'),
            'trusted' =>0,
        ]);

        factory('App\CommunityLink', 1)->create([
            'user_id'=>$user2->id,
            'approved'=>$user2->trusted,
        ]);

        factory('App\Channel')->create([
            'title' => 'PHP',
            'slug'  => 'php',
            'color'  => 'red',
        ]);

        factory('App\Channel')->create([
            'title' => 'JavasSript',
            'slug'  => 'javascript',
            'color'  => 'green',
        ]);

        factory('App\Channel')->create([
            'title' => 'Ruby',
            'slug'  => 'ruby',
            'color'  => 'pink',
        ]);

        factory('App\CommunityLink', 10);
    }
}
