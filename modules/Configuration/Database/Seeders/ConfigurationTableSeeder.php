<?php

namespace Modules\Configuration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Configuration\Entities\Configuration;


class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Configuration::class, 25)->create();
    }
}
