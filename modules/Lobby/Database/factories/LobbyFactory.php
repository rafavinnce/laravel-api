<?php

use Faker\Generator as Faker;

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

$factory->define(Modules\Lobby\Entities\Lobby::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(50),
    ];
});