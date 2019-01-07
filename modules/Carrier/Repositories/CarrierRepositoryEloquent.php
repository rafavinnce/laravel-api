<?php

namespace Modules\Carrier\Repositories;

use Modules\Carrier\Entities\Carrier;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class CarrierRepositoryEloquent extends BaseRepository implements CarrierRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Carrier::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
