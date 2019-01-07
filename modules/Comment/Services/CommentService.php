<?php

namespace Modules\Comment\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Repositories\CommentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    /**
     * The comment repository instance.
     *
     * @var CommentRepository
     */
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @param string $commentableId
     * @param string $commentableType
     * @return LengthAwarePaginator
     */
    public function paginate($commentableId, $commentableType)
    {
        return $this->commentRepository->scopeQuery(function ($query) use ($commentableId, $commentableType) {
            return $query->where(function (Builder $query) use ($commentableId, $commentableType) {
                return $query->where('commentable_type', $commentableType)->where('commentable_id', $commentableId);
            })->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @param string $commentableId
     * @param string $commentableType
     * @return Comment
     */
    public function find($id, $commentableId, $commentableType)
    {
        return $this->commentRepository->scopeQuery(function ($query) use ($commentableId, $commentableType) {
            return $query->where(function (Builder $query) use ($commentableId, $commentableType) {
                return $query->where('commentable_type', $commentableType)->where('commentable_id', $commentableId);
            });
        })->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @param string $commentableId
     * @param string $commentableType
     * @return Comment
     */
    public function create(array $attributes, $commentableId, $commentableType)
    {
        $entity = $this->commentRepository->skipPresenter(true)->create(array_merge($attributes, [
            'commentable_id' => $commentableId,
            'commentable_type' => $commentableType,
        ]));

        return $this->commentRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @param string $commentableId
     * @param string $commentableType
     * @return Comment
     */
    public function update(array $attributes, $id, $commentableId, $commentableType)
    {
        $entity = $this->commentRepository->scopeQuery(function ($query) use ($commentableId, $commentableType) {
            return $query->where(function (Builder $query) use ($commentableId, $commentableType) {
                return $query->where('commentable_type', $commentableType)
                    ->where('commentable_id', $commentableId)
                    ->where('user_id', Auth::id());
            });
        })->skipPresenter(true)->find($id);

        $entity->update($attributes);

        return $this->commentRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param string $id
     * @param string $commentableId
     * @param string $commentableType
     * @return boolean
     */
    public function destroy($id, $commentableId, $commentableType)
    {
        return $this->commentRepository->scopeQuery(function ($query) use ($commentableId, $commentableType) {
            return $query->where(function (Builder $query) use ($commentableId, $commentableType) {
                return $query->where('commentable_type', $commentableType)->where('commentable_id', $commentableId);
            });
        })->skipPresenter(true)->find($id)->delete();
    }
}