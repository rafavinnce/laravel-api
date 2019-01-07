<?php

namespace Modules\Dock\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Modules\Dock\Entities\Dock;
use Modules\Dock\Repositories\DockRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DockService
{
    /**
     * The dock repository instance.
     *
     * @var DockRepository
     */
    protected $dockRepository;

    public function __construct(DockRepository $dockRepository)
    {
        $this->dockRepository = $dockRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        if (Input::get('relation_join') === 'true') {
            return $this->dockRepository->scopeQuery(function ($query) {
                $query->select(
                    'dock_docks.id',
                    'dock_docks.name',
                    'dock_docks.created_at',
                    'shipment_shipments.box as shipment_box',
                    'shipment_loads.carrier_id as load_carrier_id',
                    'shipment_shipments.load_id as shipment_load_id',
                    'shipment_shipments.id as shipment_id',
                    'shipment_shipments.finish_at as shipment_finish_at',
                    'shipment_shipments.created_at as shipment_created_at',
                    'shipment_shipments.manifest_finish_at as shipment_manifest_finish_at',
                    'wait_waits.id as wait_id',
                    'wait_waits.driver as wait_driver',
                    'wait_waits.entry_at as wait_entry_at',
                    'wait_waits.arrival_at as wait_arrival_at',
                    'carrier_carriers.id as carrier_id',
                    'carrier_carriers.name as carrier_name',
                    'shipment_loads.id as load_id',
                    'shipment_loads.wave as load_wave',
                    'shipment_steps.id as step_id',
                    'shipment_steps.percent as step_percent',
                    'shipment_steps.type_id as step_type_id',
                    'shipment_steps.status_id as step_status_id',
                    'shipment_steps.invoice_id as step_invoice_id',
                    'status_shipment.id as status_id_shipment',
                    'status_shipment.code as status_code_shipment',
                    'status_shipment.type as status_type_shipment',
                    'status_shipment.name as status_name_shipment',
                    'status_invoice.id as status_id_invoice',
                    'status_invoice.code as status_code_invoice',
                    'status_invoice.type as status_type_invoice',
                    'status_invoice.name as status_name_invoice'
                );

                $query->leftJoin('shipment_shipments', function($join) {
                    $join->on('dock_docks.id', '=', 'shipment_shipments.dock_id')
                        ->whereNull('shipment_shipments.finish_at');
                });

                $query->leftJoin('wait_waits', 'wait_waits.id', '=', 'shipment_shipments.wait_id', 'left');

                $query->leftJoin('shipment_loads', 'shipment_loads.id', '=', 'shipment_shipments.load_id', 'left');

                $query->leftJoin('carrier_carriers', 'carrier_carriers.id', '=', 'shipment_loads.carrier_id', 'left');

                $query->leftJoin('shipment_steps', function($join) {
                    $join->on('shipment_steps.shipment_id', '=', 'shipment_shipments.id')
                        ->where('shipment_steps.id', '=',
                            DB::Raw('(select max(id) from shipment_steps where shipment_steps.shipment_id = shipment_shipments.id)'));

                });

                $query->leftJoin('status_status as status_shipment', function($join) {
                    $join->on('status_shipment.id', '=', 'shipment_steps.type_id')
                        ->where('status_shipment.code', '=',
                            DB::Raw('(select code from status_status where status_status.id = status_shipment.id)'));
                });

                $query->leftJoin('status_status as status_invoice', function($join) {
                    $join->on('status_invoice.id', '=', 'shipment_steps.invoice_id')
                        ->where('status_invoice.code', '=',
                            DB::Raw('(select code from status_status where status_status.id = status_invoice.id)'));
                });

                return $query->orderBy('id', 'desc');
            })->paginate();
        }

        return $this->dockRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Dock
     */
    public function find($id)
    {
        return $this->dockRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Dock
     */
    public function create(array $attributes)
    {
        $entity = $this->dockRepository->skipPresenter(true)->create($attributes);
        return $this->dockRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Dock
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->dockRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->dockRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->dockRepository->skipPresenter(true)->find($id)->delete();
    }
}