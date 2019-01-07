<?php

namespace Modules\Permission\Services;

use Illuminate\Support\Collection;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Nwidart\Modules\Facades\Module;

class PermissionService
{
    /**
     * The permission repository instance.
     *
     * @var PermissionRepository
     */
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->permissionRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate(-1);
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Permission
     */
    public function find($id)
    {
        return $this->permissionRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Permission
     */
    public function create(array $attributes)
    {
        $entity = $this->permissionRepository->skipPresenter(true)->create($attributes);
        return $this->permissionRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Permission
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->permissionRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->permissionRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update or Create an entity in storage.
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->permissionRepository->updateOrCreate($attributes, $values);
    }

    /**
     * Find entity by multiple fields.
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        return $this->permissionRepository->findWhere($where, $columns);
    }

    /**
     * Find entity by excluding multiple values in one field.
     *
     * @param string $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->permissionRepository->findWhereNotIn($field, $values, $columns);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->permissionRepository->skipPresenter(true)->find($id)->delete();
    }

    /**
     * Sync the permissions from all modules.
     *
     * @return Collection
     */
    public function sync()
    {
        $collection = new Collection();
        $all = [];

        foreach (Module::all() as $module) {
            $permissions = config($module->getLowerName().'.permissions');

            if ($permissions) {
                foreach ($permissions as $permission) {
                    $permission['guard'] = (!empty($permission['guard'])) ? $permission['guard'] : 'web';
                    $permission['module'] = $module->getName();
                    $all[] = $permission['name'];

                    $findCreate = $this->findWhere([
                        'name' => $permission['name'],
                    ], ['id']);

                    if (!$findCreate->count()) {
                        $entity = $this->create([
                            'name' => $permission['name'],
                            'title' => $permission['title'],
                            'module' => $module->getName(),
                            'guard_name' => $permission['guard'],
                        ]);

                        $data = $entity->toArray();
                        $data['wasRecentlyCreated'] = true;
                        $collection->push($data);
                    } else {
                        $findUpdate = $this->permissionRepository->scopeQuery(function ($query) use ($permission) {
                            return $query->where('name', $permission['name'])->where(function ($query) use ($permission) {
                                return $query->where('module', '!=', $permission['module'])->orWhere('title', '!=', $permission['title']);
                            });
                        })->all();

                        if ($findUpdate->count()) {
                            $entity = $findUpdate->first();
                            $entity->update([
                                'title' => $permission['title'],
                                'module' => $module->getName(),
                                'guard_name' => $permission['guard'],
                            ]);

                            $data = $entity->toArray();
                            $data['wasRecentlyUpdated'] = true;
                            $collection->push($data);
                        }
                    }

                }
            }
        }

        $removes = $this->findWhereNotIn('name', $all)->all();
        foreach ($removes as $entity) {
            $this->destroy($entity->id);

            $data = $entity->toArray();
            $data['wasRecentlyDeleted'] = true;
            $collection->push($data);
        }

        return $collection;
    }
}