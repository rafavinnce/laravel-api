<?php

namespace Modules\Shipment\Repositories;

use Modules\Shipment\Entities\Shipment;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ShipmentRepositoryEloquent extends BaseRepository implements ShipmentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'wait.driver' => 'ilike',
        'wait.manifest' => 'ilike',
        'wait.seal1' => 'ilike',
        'wait.seal2' => 'ilike',
        'wait.operation_id' => '=',
        'wait.carrier.name' => 'ilike',
        'wait.lobby.name' => 'ilike',
        'wait.boardHorse.board' => 'ilike',
        'dock.id' => '=',
        'dock_id' => '=',
        'dock.name' => 'ilike',
        'finish_at' => '=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Shipment::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
