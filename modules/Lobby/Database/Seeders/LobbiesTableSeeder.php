<?php

namespace Modules\Lobby\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Lobby\Entities\Lobby;

class LobbiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Lobby::class, 25)->create();
    }
}
