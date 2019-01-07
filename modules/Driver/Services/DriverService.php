<?php

namespace Modules\Driver\Services;

use Modules\Driver\Entities\Driver;
use Modules\Driver\Repositories\DriverRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DriverService
{
    /**
     * The driver repository instance.
     *
     * @var DriverRepository
     */
    protected $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->driverRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Driver
     */
    public function find($id)
    {
        return $this->driverRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Driver
     */
    public function create(array $attributes)
    {
        $entity = $this->driverRepository->skipPresenter(true)->create($attributes);
        return $this->driverRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Driver
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->driverRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->driverRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->driverRepository->skipPresenter(true)->find($id)->delete();
    }
}