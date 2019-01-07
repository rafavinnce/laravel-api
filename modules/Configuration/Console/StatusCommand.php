<?php

namespace Modules\Configuration\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Configuration\Services\ConfigurationService;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configuration:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the status of each configuration';

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
        $collection = new Collection();
        $all = [];

        foreach (config('configuration.available') as $configuration) {
            $all[] = $configuration['name'];

            $findCreate = $this->configurationService->findWhere([
                'name' => $configuration['name'],
            ], ['id']);

            if (!$findCreate->count()) {
                $configuration['status'] = '<fg=green>Create</fg=green>';
            } else {
                $findUpdate = $this->configurationService->getRepository()->scopeQuery(function ($query) use ($configuration) {
                    return $query->where('name', $configuration['name'])->where(function ($query) use ($configuration) {
                        return $query->where('type', '!=', $configuration['type'])->orWhere('title', '!=', $configuration['title']);
                    });
                })->all();

                if ($findUpdate->count()) {
                    $configuration['status'] = '<fg=yellow>Update</fg=yellow>';
                } else {
                    $configuration['status'] = '<fg=white>OK</fg=white>';
                }
            }

            $collection->push([
                'status' => $configuration['status'],
                'title' => $configuration['title'],
                'name' => $configuration['name'],
                'type' => $configuration['type'],
            ]);
        }

        $removes = $this->configurationService->findWhereNotIn('name', $all)->all();
        foreach ($removes as $configuration) {
            $collection->push([
                'status' => '<fg=red>Delete</fg=red>',
                'title' => $configuration['title'],
                'name' => $configuration['name'],
                'type' => $configuration['type'],
            ]);
        }

        $this->table(['Status', 'Title', 'Name', 'Type'], $collection->toArray());
    }
}
