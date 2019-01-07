<?php

namespace Modules\Configuration\Services;

use Illuminate\Support\Collection;
use Modules\Configuration\Entities\Configuration;
use Modules\Configuration\Repositories\ConfigurationRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ConfigurationService
{
    /**
     * The configuration repository instance.
     *
     * @var ConfigurationRepository
     */
    protected $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
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
        return $this->configurationRepository->findByField($field, $value, $columns);
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
        return $this->configurationRepository->findWhere($where, $columns);
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
        return $this->configurationRepository->findWhereNotIn($field, $values, $columns);
    }

    /**
     * Display a paginated listing of the entity.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->configurationRepository->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate();
    }

    /**
     * Find the specified entity.
     *
     * @param string $id
     * @return Configuration
     */
    public function find($id)
    {
        return $this->configurationRepository->find($id);
    }

    /**
     * Store a newly created entity in storage.
     *
     * @param array $attributes
     * @return Configuration
     */
    public function create(array $attributes)
    {
        $entity = $this->configurationRepository->skipPresenter(true)->create($attributes);
        return $this->configurationRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Update the specified entity in storage.
     *
     * @param array $attributes
     * @param string $id
     * @return Configuration
     */
    public function update(array $attributes, $id)
    {
        $entity = $this->configurationRepository->skipPresenter(true)->find($id);
        $entity->update($attributes);
        return $this->configurationRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * Remove the specified entity from storage.
     *
     * @param  string $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->configurationRepository->skipPresenter(true)->find($id)->delete();
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

        foreach (config('configuration.available') as $config) {
            $all[] = $config['name'];

            $findCreate = $this->findWhere([
                'name' => $config['name'],
            ], ['id']);

            if (!$findCreate->count()) {
                $entity = $this->create($config);

                $data = $entity->toArray();
                $data['wasRecentlyCreated'] = true;
                $collection->push($data);
            } else {
                $findUpdate = $this->configurationRepository->scopeQuery(function ($query) use ($config) {
                    return $query->where('name', $config['name'])->where(function ($query) use ($config) {
                        return $query->where('type', '!=', $config['type'])->orWhere('title', '!=', $config['title']);
                    });
                })->all();

                if ($findUpdate->count()) {
                    $entity = $findUpdate->first();
                    $entity->update($config);

                    $data = $entity->toArray();
                    $data['wasRecentlyUpdated'] = true;
                    $collection->push($data);
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

    /**
     * Get the configuration repository instance.
     *
     * @return ConfigurationRepository
     */
    public function getRepository()
    {
        return $this->configurationRepository;
    }
}