<?php

namespace Modules\Lobby\Repositories;

use Modules\Lobby\Entities\Lobby;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class LobbyRepositoryEloquent extends BaseRepository implements LobbyRepository
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
        return Lobby::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
