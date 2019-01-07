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

$factory->define(Modules\Vehicle\Entities\Vehicle::class, function (Faker $faker) {
    return [
        'board' => $faker->unique()->regexify('[A-Z]{3}-[0-9]{4}'),
    ];
});