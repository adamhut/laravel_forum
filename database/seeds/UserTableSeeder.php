<?php

use App\User;
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
                'name' => 'adam',
                'email' => 'adam@example.com',
                'password' => bcrypt('secret'),
            ]);
        factory(User::class)
            ->create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('secret'),
            ]);
    }
}
