<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        factory(User::class)
            ->create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('secret'),
            ]);

    }
}
