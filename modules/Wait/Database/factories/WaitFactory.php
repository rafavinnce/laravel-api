<?php

//namespace Modules\Wait\Factories;

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

$factory->define(Modules\Wait\Entities\Wait::class, function (Faker $faker) {
    return [
        'driver' => $faker->unique()->name(),
        'manifest' => $faker->unique()->text(32),
        'seal1' => $faker->unique()->text(32),
        'seal2' => $faker->unique()->text(32),
        'authorized_by' => $faker->unique()->name(),
        'arrival_at' => $faker->dateTime(),
        'entry_at' => $faker->dateTime(),
        'output_at' => $faker->dateTime(),
        'operation_id' => factory(\Modules\Operation\Entities\Operation::class)->create()->id,
        'board_horse_id' => factory(\Modules\Vehicle\Entities\Vehicle::class)->create()->id,
        'board_cart_id' => factory(\Modules\Vehicle\Entities\Vehicle::class)->create()->id,
        'carrier_id' => factory(\Modules\Carrier\Entities\Carrier::class)->create()->id,
        'lobby_id' => factory(\Modules\Lobby\Entities\Lobby::class)->create()->id,
    ];
});