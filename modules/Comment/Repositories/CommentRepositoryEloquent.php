<?php

namespace Modules\Comment\Repositories;

use Modules\Comment\Entities\Comment;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'comment' => 'ilike',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
