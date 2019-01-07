<?php

namespace Modules\Operation\Services;

use Modules\Operation\Entities\Operation;
use Modules\Operation\Repositories\OperationRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class OperationService
{
    /**
     * The operation repository instance.
     *
     * @var OperationRepository
     */
    protected $operationRepository;

    public function __construct(OperationRepository $operationRepository)
    {
        $this->operationRepository = $operationRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->operationRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Operation
     */
    public function find($id)
    {
        return $this->operationRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Operation
     */
    public function create(array $attributes)
    {
        $entity = $this->operationRepository->skipPresenter(true)->create($attributes);
        return $this->operationRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Operation
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->operationRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->operationRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->operationRepository->skipPresenter(true)->find($id)->delete();
    }

    /**
     * Get the operation repository instance.
     *
     * @return OperationRepository
     */
    public function getRepository()
    {
        return $this->operationRepository;
    }
}