<?php

namespace Modules\Permission\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Permission\Services\PermissionService;

class SyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the permissions from all modules';

    /**
     * The permission service instance.
     *
     * @var PermissionService
     */
    protected $permissionService;
    
    /**
     * Create a new command instance.
     *
     * @param $permissionService PermissionService
     * @return void
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
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
        $collection = $this->permissionService->sync();

        if ($collection->count()) {
            foreach ($collection as $item) {
                if (!empty($item['wasRecentlyCreated'])) {
                    $this->info('New permission created successfully.');
                } elseif (!empty($item['wasRecentlyUpdated'])) {
                    $this->info('The permission updated successfully.');
                } elseif (!empty($item['wasRecentlyDeleted'])) {
                    $this->info('The permission removed successfully.');
                }

                $this->line(sprintf('<comment>Permission ID:</comment> %d', $item['id']));
                $this->line(sprintf('<comment>Permission name:</comment> %s', $item['name']));
                $this->line(sprintf('<comment>Permission title:</comment> %s', $item['title']));
                $this->line(sprintf('<comment>Permission module:</comment> %s', $item['module']));
            }
        } else {
            $this->info('Nothing to sync.');
        }
    }
}
