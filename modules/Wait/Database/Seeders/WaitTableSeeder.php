<?php

namespace Modules\Wait\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Wait\Entities\Wait;

class WaitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Wait::class, 25)->create();
    }
}
