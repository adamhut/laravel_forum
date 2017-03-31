<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Thread::class, function (Faker\Generator $faker) {
    // /static $password;

    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'channel_id' =>function(){
            return factory('App\ForumChannel')->create()->id;
        },
        'user_id' => function(){
        	return factory('App\User')->create()->id;
        },
        
     ];
});

$factory->define(App\Reply::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'thread_id' => function(){
        	return factory('App\Thread')->create()->id;
        },
        'user_id' => function(){
        	return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph,
     ];
});


$factory->define(App\CommunityLink::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'user_id'=>function(){
            return factory('App\User')->create()->id;
        },
        'channel_id'=> 1 ,
        'title'=>$faker->sentence,
        'url'=>$faker->url,
        'approved'=>0,
    ];
});

$factory->define(App\Channel::class, function (Faker\Generator $faker) {
    $name = $faker->sentence;
     return [
        'title'=>$name,
        'slug'=> strtolower($name) ,
        'color'=>'red',
    ];
});

$factory->define(App\ForumChannel::class, function (Faker\Generator $faker) {
      $name = $faker->word;
     return [
        'name'=> $name,
        'slug'=> $name,
    ];
});