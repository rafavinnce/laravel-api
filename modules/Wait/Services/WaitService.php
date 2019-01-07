<?php

namespace Modules\Wait\Services;

use Carbon\Carbon;
use Modules\Wait\Entities\Wait;
use Modules\Wait\Repositories\WaitRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Account\Services\AccountService;

class WaitService
{
    /**
     * The wait repository instance.
     *
     * @var WaitRepository
     */
    protected $waitRepository;

    /**
     * Flatten export csv
     *
     * @return Response
     */
    protected $flatten = [
        'board_horse' => 'board',
        'board_cart' => 'board',
        'lobby' => 'name',
        'operation' => 'name',
        'carrier' => 'name',
    ];

    /**
     * Header export csv
     *
     * @return Response
     */
    protected $headerCsv = [
        "id", 
        "Motorista",
        "Manifesto",
        "seal1",
        "seal2",
        "Autorizado para",
        "Chegada em",
        "Entrada em",
        "Saida em",
        "operation_id",
        "board_horse_id",
        "board_cart_id",
        "carrier_id",
        "lobby_id",
        "Criado em",
        "Atualizado em"
    ];

    public function __construct(WaitRepository $waitRepository, AccountService $accountService)
    {
        $this->waitRepository = $waitRepository;
        $this->accountService = $accountService;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->waitRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Wait
     */
    public function find($id)
    {
        return $this->waitRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Wait
     */
    public function create(array $attributes)
    {
        $entity = $this->waitRepository->skipPresenter(true)->create($attributes);
        return $this->waitRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Wait
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->waitRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->waitRepository->skipPresenter(false)->find($entity->id);
    }

     /**
     * Generate CSV data
     *
     * @return String
     */
    public function download()
    {
        $this->checkIfTokenExists();

        $wait = $this->waitRepository->scopeQuery(function($query) {
            $startDate = request()->query('startDate');
            $endDate = request()->query('endDate');

            return $query
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('carrier','operation','boardHorse','boardCart','lobby');
        })
        ->all()
        ->map(function($wait){
            unset($wait['operation_id'],$wait['board_horse_id'],$wait['board_cart_id'],$wait['carrier_id'],$wait['lobby_id']);
            return $wait;
        })
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
        return $this->waitRepository->skipPresenter(true)->find($id)->delete();
    }
}