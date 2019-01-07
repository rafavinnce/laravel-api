<?php

namespace Modules\Status\Services;

use Illuminate\Support\Collection;
use Modules\Status\Entities\Status;
use Modules\Status\Repositories\StatusRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class StatusService
{
    /**
     * The status repository instance.
     *
     * @var StatusRepository
     */
    protected $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->statusRepository->findByField($field, $value, $columns);
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
        return $this->statusRepository->findWhere($where, $columns);
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
        return $this->statusRepository->findWhereNotIn($field, $values, $columns);
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->statusRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Status
     */
    public function find($id)
    {
        return $this->statusRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Status
     */
    public function create(array $attributes)
    {
        $entity = $this->statusRepository->skipPresenter(true)->create($attributes);
        return $this->statusRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Status
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->statusRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->statusRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->statusRepository->skipPresenter(true)->find($id)->delete();
    }

    /**
     * Sync the status options.
     *
     * @return Collection
     */
    public function sync()
    {
        $collection = new Collection();
        $all = [];

        foreach (config('status.available') as $status) {
            $all[] = $status['code'];

            $findCreate = $this->findWhere([
                'code' => $status['code'],
            ], ['id']);

            if (!$findCreate->count()) {
                $entity = $this->create($status);

                $data = $entity->toArray();
                $data['wasRecentlyCreated'] = true;
                $collection->push($data);
            } else {
                $findUpdate = $this->statusRepository->scopeQuery(function ($query) use ($status) {
                    return $query->where('code', $status['code'])->where(function ($query) use ($status) {
                        return $query->where('type', '!=', $status['type'])->orWhere('name', '!=', $status['name']);
                    });
                })->all();

                if ($findUpdate->count()) {
                    $entity = $findUpdate->first();
                    $entity->update($status);

                    $data = $entity->toArray();
                    $data['wasRecentlyUpdated'] = true;
                    $collection->push($data);
                }
            }
        }

        $removes = $this->findWhereNotIn('code', $all)->all();
        foreach ($removes as $entity) {
            $this->destroy($entity->id);

            $data = $entity->toArray();
            $data['wasRecentlyDeleted'] = true;
            $collection->push($data);
        }

        return $collection;
    }

    /**
     * Get the status repository instance.
     *
     * @return StatusRepository
     */
    public function getRepository()
    {
        return $this->statusRepository;
    }
}