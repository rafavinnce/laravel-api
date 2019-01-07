<?php

namespace Modules\Vehicle\Services;

use Modules\Vehicle\Entities\Vehicle;
use Modules\Vehicle\Repositories\VehicleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class VehicleService
{
    /**
     * The vehicle repository instance.
     *
     * @var VehicleRepository
     */
    protected $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->vehicleRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Vehicle
     */
    public function find($id)
    {
        return $this->vehicleRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Vehicle
     */
    public function create(array $attributes)
    {
        $entity = $this->vehicleRepository->skipPresenter(true)->create($attributes);
        return $this->vehicleRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Vehicle
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->vehicleRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->vehicleRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->vehicleRepository->skipPresenter(true)->find($id)->delete();
    }

    /**
     * Get the vehicle repository instance.
     *
     * @return VehicleRepository
     */
    public function getRepository()
    {
        return $this->vehicleRepository;
    }
}