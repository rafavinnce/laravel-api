<?php

namespace Modules\Configuration\Repositories;

use Modules\Configuration\Entities\Configuration;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ConfigurationRepositoryEloquent extends BaseRepository implements ConfigurationRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title' => 'ilike',
        'name' => 'ilike',
        'type' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configuration::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
