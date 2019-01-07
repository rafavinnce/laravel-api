<?php

namespace Modules\Operation\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Operation\Entities\Operation;

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Operation::class, 25)->create();
    }
}
