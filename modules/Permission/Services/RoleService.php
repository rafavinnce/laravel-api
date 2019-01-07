<?php

namespace Modules\Permission\Services;

use Modules\Permission\Entities\Role;
use Modules\Permission\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{
    /**
     * The role repository instance.
     *
     * @var RoleRepository
     */
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->roleRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Role
     */
    public function find($id)
    {
        return $this->roleRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Role
     */
    public function create(array $attributes)
    {
        $entity = $this->roleRepository->skipPresenter(true)->create($attributes);

        if (isset($attributes['permissions'])) {
            $entity->syncPermissions($attributes['permissions']);
        }

        if (isset($attributes['users'])) {
            $entity->users()->sync($attributes['users']);
        }

        return $this->roleRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Role
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->roleRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);

        if (isset($attributes['permissions'])) {
            $entity->syncPermissions($attributes['permissions']);
        }

        if (isset($attributes['users'])) {
            $entity->users()->sync($attributes['users']);
        }

        return $this->roleRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->roleRepository->skipPresenter(true)->find($id)->delete();
    }
}