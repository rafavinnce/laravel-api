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

$factory->define(Modules\Carrier\Entities\Carrier::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(100),
        'is_casual' => $faker->boolean,
        'operation_start' => $faker->time('H:i'),
        'operation_end' => $faker->time('H:i'),
        'id_external' => $faker->unique()->numberBetween(1, 100),
    ];
});