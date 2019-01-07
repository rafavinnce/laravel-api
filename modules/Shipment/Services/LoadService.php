<?php

namespace Modules\Shipment\Services;

use Illuminate\Support\Facades\Input;
use Modules\Shipment\Entities\Load;
use Modules\Shipment\Repositories\LoadRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class LoadService
{
    /**
     * The load repository instance.
     *
     * @var LoadRepository
     */
    protected $loadRepository;

    public function __construct(LoadRepository $loadRepository)
    {
        $this->loadRepository = $loadRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->loadRepository->scopeQuery(function ($query) {
            if (Input::get('unique', false)) {
                return $query->doesntHave('shipments')->orderBy('id', 'desc');
            }

            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Load
     */
    public function find($id)
    {
        return $this->loadRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Load
     */
    public function create(array $attributes)
    {
        $entity = $this->loadRepository->skipPresenter(true)->create($attributes);
        return $this->loadRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Load
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->loadRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->loadRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->loadRepository->skipPresenter(true)->find($id)->delete();
    }
}