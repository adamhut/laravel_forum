<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CommunityLinksSeeder::class);
        //$this->call(ThreadAndReplyTableSeeder::class);
        $this
            ->call(UsersSeeder::class)
            ->call(SampleDataSeeder::class);
    }
}
