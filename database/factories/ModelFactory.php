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
        'type' => 'member',
        'remember_token' => str_random(10),
        'confirmed' => true,
    ];
});

$factory->state(App\User::class, 'admin', function (Faker\Generator $faker) {
    return ['type'=>'admin'];
});

$factory->state(App\User::class, 'unconfirmed', function (Faker\Generator $faker) {
    return [
        'confirmed'=>false,
    ];
});

$factory->define(App\Thread::class, function (Faker\Generator $faker) {
    // /static $password;
    $title = $faker->sentence;

    return [
        'title' => $title,
        'body' => $faker->paragraph,
        'channel_id' =>function () {
            return factory('App\Channel')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'slug' => str_slug($title),
        'locked' => false,
        'pinned' => false,
     ];
});

$factory->define(App\Reply::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph,
     ];
});

$factory->define(App\CommunityLink::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'user_id'=>function () {
            return factory('App\User')->create()->id;
        },
        'channel_id'=> 1,
        'title'=>$faker->sentence,
        'url'=>$faker->url,
        'approved'=>0,
    ];
});

$factory->define(App\CommunityChannel::class, function ($faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
        'archived' => false,
    ];
});

$factory->define(App\Channel::class, function ($faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
        'archived' => false,
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function ($faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar'],
    ];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User)->create(),
        'message' =>  $faker->paragraph,
     ];
});
