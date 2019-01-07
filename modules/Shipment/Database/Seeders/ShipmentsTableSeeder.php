<?php

namespace Modules\Shipment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shipment\Entities\Shipment;

class ShipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Shipment::class, 25)->create();
    }
}
