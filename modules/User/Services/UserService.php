<?php

namespace Modules\User\Services;

use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->userRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return User
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes)
    {
        $entity = $this->userRepository->skipPresenter(true)->create($attributes);

        if (!empty($attributes['roles'])) {
            $entity->syncRoles($attributes['roles']);
        }

        if (!empty($attributes['permissions'])) {
            $entity->syncPermissions($attributes['permissions']);
        }

        return $this->userRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return User
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->userRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);

        if (!empty($attributes['roles'])) {
            $entity->syncRoles($attributes['roles']);
        }

        if (!empty($attributes['permissions'])) {
            $entity->syncPermissions($attributes['permissions']);
        }

        return $this->userRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->userRepository->skipPresenter(true)->find($id)->delete();
    }

}