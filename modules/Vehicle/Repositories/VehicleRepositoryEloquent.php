<?php

namespace Modules\Vehicle\Repositories;

use Modules\Vehicle\Entities\Vehicle;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class VehicleRepositoryEloquent extends BaseRepository implements VehicleRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'board' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vehicle::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
