<?php

namespace Modules\Shipment\Repositories;

use Modules\Shipment\Entities\Step;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class StepRepositoryEloquent extends BaseRepository implements StepRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'shipment_id' => '=',
        'shipment.wait.driver' => 'ilike',
        'shipment.wait.manifest' => 'ilike',
        'shipment.wait.seal1' => 'ilike',
        'shipment.wait.seal2' => 'ilike',
        'shipment.wait.operation.name' => 'ilike',
        'shipment.wait.carrier.name' => 'ilike',
        'shipment.wait.lobby' => '=',
        'shipment.dock.name' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Step::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
