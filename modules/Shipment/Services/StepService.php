<?php

namespace Modules\Shipment\Services;

use Modules\Shipment\Entities\Step;
use Modules\Shipment\Repositories\StepRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class StepService
{
    /**
     * The step repository instance.
     *
     * @var StepRepository
     */
    protected $stepRepository;

    public function __construct(StepRepository $stepRepository)
    {
        $this->stepRepository = $stepRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->stepRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Step
     */
    public function find($id)
    {
        return $this->stepRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Step
     */
    public function create(array $attributes)
    {
        $entity = $this->stepRepository->skipPresenter(true)->create($attributes);
        return $this->stepRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Step
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->stepRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->stepRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->stepRepository->skipPresenter(true)->find($id)->delete();
    }
}