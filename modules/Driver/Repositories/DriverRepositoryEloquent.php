<?php

namespace Modules\Driver\Repositories;

use Modules\Driver\Entities\Driver;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class DriverRepositoryEloquent extends BaseRepository implements DriverRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'ilike',
        'document' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Driver::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
