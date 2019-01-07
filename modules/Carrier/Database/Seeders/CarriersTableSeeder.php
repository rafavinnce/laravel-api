<?php

namespace Modules\Carrier\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Carrier\Entities\Carrier;

class CarriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Carrier::class, 25)->create();
    }
}
