<?php

namespace Modules\Configuration\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Configuration\Services\ConfigurationService;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configuration:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the configuration from config';

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
        $migrates = new Collection();

        foreach (config('configuration.available') as $configuration) {
            if (!$this->configurationService->findByField('name', $configuration['name'], ['id'])->count()) {
                $entity = $this->configurationService->create($configuration);

                $this->info('New configuration created successfully.');
                $this->line(sprintf('<comment>Configuration ID:</comment> %d', $entity->id));
                $this->line(sprintf('<comment>Configuration name:</comment> %s', $entity->name));
                $this->line(sprintf('<comment>Configuration title:</comment> %s', $entity->title));
                $this->line(sprintf('<comment>Configuration type:</comment> %s', $entity->type));

                $migrates->push($entity);
            }
        }

        if (!$migrates->count()) {
            $this->info('Nothing to migrate.');
        }
    }
}
