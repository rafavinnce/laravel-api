<?php

namespace Modules\Shipment\Services;

use Modules\Shipment\Entities\Pendency;
use Modules\Shipment\Repositories\PendencyRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PendencyService
{
    /**
     * The pendency repository instance.
     *
     * @var PendencyRepository
     */
    protected $pendencyRepository;

    public function __construct(PendencyRepository $pendencyRepository)
    {
        $this->pendencyRepository = $pendencyRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->pendencyRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Pendency
     */
    public function find($id)
    {
        return $this->pendencyRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Pendency
     */
    public function create(array $attributes)
    {
        $entity = $this->pendencyRepository->skipPresenter(true)->create($attributes);
        return $this->pendencyRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Pendency
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->pendencyRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->pendencyRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->pendencyRepository->skipPresenter(true)->find($id)->delete();
    }
}