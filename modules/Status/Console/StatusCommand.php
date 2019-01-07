<?php

namespace Modules\Status\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Status\Services\StatusService;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the status of each status';

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
        $collection = new Collection();
        $all = [];

        foreach (config('status.available') as $status) {
            $all[] = $status['code'];

            $findCreate = $this->statusService->findWhere([
                'code' => $status['code'],
            ], ['id']);

            if (!$findCreate->count()) {
                $status['status'] = '<fg=green>Create</fg=green>';
            } else {
                $findUpdate = $this->statusService->getRepository()->scopeQuery(function ($query) use ($status) {
                    return $query->where('code', $status['code'])->where(function ($query) use ($status) {
                        return $query->where('type', '!=', $status['type'])->orWhere('name', '!=', $status['name']);
                    });
                })->all();

                if ($findUpdate->count()) {
                    $status['status'] = '<fg=yellow>Update</fg=yellow>';
                } else {
                    $status['status'] = '<fg=white>OK</fg=white>';
                }
            }

            $collection->push([
                'status' => $status['status'],
                'code' => $status['code'],
                'type' => $status['type'],
                'name' => $status['name'],
            ]);
        }

        $removes = $this->statusService->findWhereNotIn('code', $all)->all();
        foreach ($removes as $status) {
            $collection->push([
                'status' => '<fg=red>Delete</fg=red>',
                'code' => $status['code'],
                'type' => $status['type'],
                'name' => $status['name'],
            ]);
        }

        $this->table(['Status', 'Code', 'Type', 'Name'], $collection->toArray());
    }
}
