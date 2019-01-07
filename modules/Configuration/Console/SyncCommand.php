<?php

namespace Modules\Configuration\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Configuration\Services\ConfigurationService;

class SyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configuration:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the configuration from config';

    /**
     * The configuration service instance.
     *
     * @var ConfigurationService
     */
    protected $configurationService;
    
    /**
     * Create a new command instance.
     *
     * @param $configurationService ConfigurationService
     * @return void
     */
    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
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
        $collection = $this->configurationService->sync();

        if ($collection->count()) {
            foreach ($collection as $item) {
                if (!empty($item['wasRecentlyCreated'])) {
                    $this->info('New configuration created successfully.');
                } elseif (!empty($item['wasRecentlyUpdated'])) {
                    $this->info('The configuration updated successfully.');
                } elseif (!empty($item['wasRecentlyDeleted'])) {
                    $this->info('The configuration removed successfully.');
                }

                $this->line(sprintf('<comment>Configuration ID:</comment> %d', $item['id']));
                $this->line(sprintf('<comment>Configuration name:</comment> %s', $item['name']));
                $this->line(sprintf('<comment>Configuration title:</comment> %s', $item['title']));
                $this->line(sprintf('<comment>Configuration type:</comment> %s', $item['type']));
            }
        } else {
            $this->info('Nothing to sync.');
        }
    }
}
