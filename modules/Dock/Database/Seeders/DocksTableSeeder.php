<?php

namespace Modules\Dock\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Dock\Entities\Dock;

class DocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Dock::class, 25)->create();
    }
}
