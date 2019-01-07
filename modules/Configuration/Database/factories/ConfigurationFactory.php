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

$factory->define(Modules\Configuration\Entities\Configuration::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(100),
        'name' => $faker->unique()->text(64),
        'type' => $faker->text(64),
        'value' => [
            'checked' => false,
            'dimensions' => [
                'width' => 5,
                'height' => 10,
            ],
            'id' => 1,
            'name' => 'A green door',
            'price' => 12.5,
            'tags' => [
                'home',
                'green',
            ],
        ],
    ];
});