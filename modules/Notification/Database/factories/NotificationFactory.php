<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your module. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Modules\Notification\Entities\Notification::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(100),
        'message' => $faker->text(255),
        'type' => $faker->randomElement(['type-faker-1', 'type-faker-2', 'type-faker-3']),
    ];
});

$factory->define(Modules\Notification\Entities\Comment::class, function (Faker $faker) {
    $user = DB::table('user_users')->inRandomOrder()->first();

    return [
        'comment' => $faker->text(512),
        'user_id' => ($user) ? $user->id : null,
    ];
});