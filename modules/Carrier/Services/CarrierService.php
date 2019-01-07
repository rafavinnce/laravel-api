<?php

namespace Modules\Carrier\Services;

use Modules\Carrier\Entities\Carrier;
use Modules\Carrier\Repositories\CarrierRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Account\Services\AccountService;

class CarrierService
{
    /**
     * The carrier repository instance.
     *
     * @var CarrierRepository
     */
    protected $carrierRepository;

    /**
     * Flatten export csv
     *
     * @return Response
     */
    protected $flatten = [
    ];

    /**
     * Header export csv
     *
     * @return Response
     */
    protected $headerCsv = [
        'Id',
        'Nome',
        'Id externo',
        'id casual',
        'Operacional inicio',
        'Operacional fim',
        "Criado em",
        "Atualizado em"
    ];

    public function __construct(CarrierRepository $carrierRepository, AccountService $accountService)
    {
        $this->carrierRepository = $carrierRepository;
        $this->accountService = $accountService;
    }

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param array $attributes
     * @param array $values
     * @return Carrier
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return app($this->carrierRepository->model())->firstOrCreate($attributes, $values);
    }

    /**
     * Find data by multiple fields.
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        return $this->carrierRepository->findWhere($where, $columns);
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->carrierRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *use Modules\Account\Services\AccountService;
     * @param string $id
     * @return Carrier
     */
    public function find($id)
    {
        return $this->carrierRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Carrier
     */
    public function create(array $attributes)
    {
        $entity = $this->carrierRepository->skipPresenter(true)->create($attributes);
        return $this->carrierRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Carrier
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->carrierRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->carrierRepository->skipPresenter(false)->find($entity->id);
    }

     /**
     * Generate CSV data
     *
     * @return String
     */
    public function download()
    {
        $this->checkIfTokenExists();

        $wait = $this->carrierRepository->scopeQuery(function($query) {
            $startDate = request()->query('startDate');
            $endDate = request()->query('endDate');
            
            return $query->whereBetween('created_at', [$startDate, $endDate]);
        })
        ->all()
        ->toArray();

        $planning = planning_csv($wait, $this->flatten);
        return generate_csv($this->headerCsv, $planning);
    }

    /**
     * Check if token exists
     *
     * @param 
     * @return boolean
     */
    private function checkIfTokenExists()
    {
        $token = request()->query('token');
        $this->accountService->find($token);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->carrierRepository->skipPresenter(true)->find($id)->delete();
    }
}