<?php

namespace Modules\Notification\Services;

use Carbon\Carbon;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    /**
     * The notification repository instance.
     *
     * @var NotificationRepository
     */
    protected $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->notificationRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Notification
     */
    public function find($id)
    {
        return $this->notificationRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Notification
     */
    public function create(array $attributes)
    {
        $entity = $this->notificationRepository->skipPresenter(true)->create($attributes);
        return $this->notificationRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Notification
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->notificationRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->notificationRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->notificationRepository->skipPresenter(true)->find($id)->delete();
    }
}