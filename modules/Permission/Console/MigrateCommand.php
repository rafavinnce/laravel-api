<?php

namespace Modules\Permission\Console;

use Illuminate\Console\Command;
use Modules\Permission\Services\PermissionService;
use Nwidart\Modules\Facades\Module;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the permissions from all modules';

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
        $migrates = [];

        foreach (Module::all() as $module) {
            $permissions = config($module->getLowerName().'.permissions');

            if ($permissions) {
                foreach ($permissions as $permission) {
                    $permission['guard'] = (!empty($permission['guard'])) ? $permission['guard'] : 'web';

                    $find = $this->permissionService->findWhere([
                        'name' => $permission['name'], 'module' => $module->getName(),
                    ], ['id']);

                    if (!$find->count()) {
                        $entity = $this->permissionService->create([
                            'name' => $permission['name'],
                            'title' => $permission['title'],
                            'module' => $module->getName(),
                            'guard_name' => $permission['guard'],
                        ]);

                        $this->info('New permission created successfully.');
                        $this->line(sprintf('<comment>Permission ID:</comment> %d', $entity->id));
                        $this->line(sprintf('<comment>Permission name:</comment> %s', $entity->name));
                        $this->line(sprintf('<comment>Permission title:</comment> %s', $entity->title));
                        $this->line(sprintf('<comment>Permission module:</comment> %s', $entity->module));

                        $migrates[] = $entity;
                    }
                }
            }
        }

        if (empty($migrates)) {
            $this->info('Nothing to migrate.');
        }
    }
}
