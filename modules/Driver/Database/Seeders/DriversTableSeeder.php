<?php

namespace Modules\Driver\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Driver\Entities\Driver;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Driver::class, 25)->create();
    }
}
