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

$factory->define(Modules\Permission\Entities\Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->regexify('[a-z]{3}\.[a-z]{3}'),
        'title' => $faker->unique()->text(80),
        'module' => $faker->unique()->text(32),
        'guard_name' => 'web',
    ];
});

$factory->define(Modules\Permission\Entities\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text(64),
        'guard_name' => 'web',
    ];
});