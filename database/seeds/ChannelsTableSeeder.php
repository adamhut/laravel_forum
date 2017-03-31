<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::truncate();
        //
        factory('App\Channel')->create([
        	'title' => 'php',
        	'slug'  => '',
        	'color' => '#FF0000'
        ]);
       
    }
}
