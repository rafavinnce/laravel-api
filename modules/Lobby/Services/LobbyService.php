<?php

namespace Modules\Lobby\Services;

use Modules\Lobby\Entities\Lobby;
use Modules\Lobby\Repositories\LobbyRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class LobbyService
{
    /**
     * The dock repository instance.
     *
     * @var LobbyRepository
     */
    protected $lobbyRepository;

    public function __construct(LobbyRepository $lobbyRepository)
    {
        $this->lobbyRepository = $lobbyRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->lobbyRepository->scopeQuery(function ($query) {
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
        return $this->lobbyRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Dock
     */
    public function create(array $attributes)
    {
        $entity = $this->lobbyRepository->skipPresenter(true)->create($attributes);
        return $this->lobbyRepository->skipPresenter(false)->find($entity->id);
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
        $entity = $this->lobbyRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->lobbyRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->lobbyRepository->skipPresenter(true)->find($id)->delete();
    }

    /**
     * Get the lobby repository instance.
     *
     * @return LobbyRepository
     */
    public function getRepository()
    {
        return $this->lobbyRepository;
    }
}