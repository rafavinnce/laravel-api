<?php

namespace Modules\Carrier\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CarrierDatabaseSeeder extends Seeder
{
    /**
     * The tables to be truncated before of seeding.
     *
     * @var array
     */
    protected $truncates = [
        'carrier_carriers',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach ($this->truncates as $table) {
            $this->command->getOutput()->writeln(sprintf('<comment>Truncating:</comment> %s', $table));
            DB::statement(sprintf('TRUNCATE TABLE %s RESTART IDENTITY CASCADE;', $table));
            $this->command->getOutput()->writeln(sprintf('<info>Truncated:</info> %s', $table));
        }

        $this->call(CarriersTableSeeder::class);

        Model::reguard();
    }
}
