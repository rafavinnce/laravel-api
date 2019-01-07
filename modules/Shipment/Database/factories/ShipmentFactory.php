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

$factory->define(Modules\Shipment\Entities\Shipment::class, function (Faker $faker) {
    return [
        'wait_id' => factory(\Modules\Wait\Entities\Wait::class)->create()->id,
        'dock_id' => factory(\Modules\Dock\Entities\Dock::class)->create()->id,
        'carrier_id' => factory(\Modules\Carrier\Entities\Carrier::class)->create()->id,
        'operation_id' => factory(\Modules\Operation\Entities\Operation::class)->create()->id,
        'box' => $faker->unique()->text(20),
        'finish_at' => $faker->dateTime(),
        'manifest_finish_at' => $faker->dateTime(),
    ];
});