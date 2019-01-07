<?php

namespace Modules\Notification\Repositories;

use Modules\Notification\Entities\Notification;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title' => 'ilike',
        'type' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
