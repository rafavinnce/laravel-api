<?php

namespace Modules\Status\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Status\Services\StatusService;

class SyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the status from config';

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
        /* @var $collection Collection */
        $collection = $this->statusService->sync();

        if ($collection->count()) {
            foreach ($collection as $item) {
                if (!empty($item['wasRecentlyCreated'])) {
                    $this->info('New status created successfully.');
                } elseif (!empty($item['wasRecentlyUpdated'])) {
                    $this->info('The status updated successfully.');
                } elseif (!empty($item['wasRecentlyDeleted'])) {
                    $this->info('The status removed successfully.');
                }

                $this->line(sprintf('<comment>Status ID:</comment> %d', $item['id']));
                $this->line(sprintf('<comment>Status name:</comment> %s', $item['name']));
                $this->line(sprintf('<comment>Status code:</comment> %d', $item['code']));
                $this->line(sprintf('<comment>Status type:</comment> %s', $item['type']));
            }
        } else {
            $this->info('Nothing to sync.');
        }
    }
}
