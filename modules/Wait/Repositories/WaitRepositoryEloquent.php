<?php

namespace Modules\Wait\Repositories;

use Modules\Wait\Entities\Wait;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class WaitRepositoryEloquent extends BaseRepository implements WaitRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'driver' => 'ilike',
        'manifest' => 'ilike',
        'seal1' => 'ilike',
        'seal2' => 'ilike',
        'authorized_by' => 'ilike',
        'boardHorse.board' => 'ilike',
        'lobby.name' => 'ilike',
        'operation.name' => 'ilike',
        'carrier.name' => 'ilike',
        'shipment.finish_at' => '=',
        'shipment.manifest_finish_at' => '=',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Wait::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
