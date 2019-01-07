<?php

namespace Modules\Status\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Status\Entities\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Status::class, 25)->create();
    }
}
