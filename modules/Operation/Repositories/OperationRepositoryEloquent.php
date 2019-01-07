<?php

namespace Modules\Operation\Repositories;

use Modules\Operation\Entities\Operation;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class OperationRepositoryEloquent extends BaseRepository implements OperationRepository
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
        return Operation::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
