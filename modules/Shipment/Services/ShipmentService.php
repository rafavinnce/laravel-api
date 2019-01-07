<?php

namespace Modules\Shipment\Services;

use Illuminate\Http\Request;
use Modules\Shipment\Entities\Shipment;
use Modules\Shipment\Repositories\ShipmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ShipmentService
{
    /**
     * The shipment repository instance.
     *
     * @var ShipmentRepository
     */
    protected $shipmentRepository;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    public function __construct(ShipmentRepository $shipmentRepository, Request $request)
    {
        $this->shipmentRepository = $shipmentRepository;
        $this->request = $request;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        if ($this->request->input('finish') === 'true') {
            return $this->shipmentRepository->scopeQuery(function ($query) {
                return $query->whereNull('finish_at')->orderBy('id', 'desc');
            })->paginate();
        }

        return $this->shipmentRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Shipment
     */
    public function find($id)
    {
        return $this->shipmentRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Shipment
     */
    public function create(array $attributes)
    {
        $entity = $this->shipmentRepository->skipPresenter(true)->create($attributes);
        return $this->shipmentRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Shipment
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->shipmentRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->shipmentRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->shipmentRepository->skipPresenter(true)->find($id)->delete();
    }
}