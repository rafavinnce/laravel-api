<?php

namespace Modules\Permission\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RefreshCommand extends Command
{
    /**
     * The tables to be truncated before of seeding.
     *
     * @var array
     */
    protected $truncates = [
        'permission_permissions',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset and re-migrate all permissions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Model::unguard();
        foreach ($this->truncates as $table) {
            $this->line(sprintf('<comment>Truncating:</comment> %s', $table));
            DB::statement(sprintf('TRUNCATE TABLE %s RESTART IDENTITY CASCADE;', $table));
            $this->line(sprintf('<info>Truncated:</info> %s', $table));
        }
        Model::reguard();

        $this->call('permission:migrate');
    }
}
