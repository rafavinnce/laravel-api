<?php

namespace Modules\Shipment\Repositories;

use Modules\Shipment\Entities\Load;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class LoadRepositoryEloquent extends BaseRepository implements LoadRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'wave' => 'ilike',
        'carrier.name' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Load::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
