<?php

namespace Modules\Status\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Status\Services\StatusService;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the status from config';

    /**
     * The status service instance.
     *
     * @var StatusService
     */
    protected $statusService;

    /**
     * Create a new command instance.
     *
     * @param $statusService StatusService
     * @return void
     */
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $migrates = new Collection();

        foreach (config('status.available') as $status) {
            if (!$this->statusService->findByField('code', $status['code'], ['id'])->count()) {
                $entity = $this->statusService->create($status);

                $this->info('New status created successfully.');
                $this->line(sprintf('<comment>Status ID:</comment> %d', $entity->id));
                $this->line(sprintf('<comment>Status name:</comment> %s', $entity->name));
                $this->line(sprintf('<comment>Status code:</comment> %d', $entity->code));
                $this->line(sprintf('<comment>Status type:</comment> %s', $entity->type));

                $migrates->push($entity);
            }
        }

        if (!$migrates->count()) {
            $this->info('Nothing to migrate.');
        }
    }
}
