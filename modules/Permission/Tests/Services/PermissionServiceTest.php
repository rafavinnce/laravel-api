<?php

namespace Modules\Permission\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Services\PermissionService;
use Nwidart\Modules\Facades\Module;
use Tests\TestCase;

class PermissionServiceTest extends TestCase
{
    /**
     * The permission service instance.
     *
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('passport:install');

        $this->permissionService = $this->app->make(PermissionService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'name' => 'users.index',
            'title' => 'List users',
            'guard_name' => 'web',
            'module' => 'User',
        ];

        $entity = $this->permissionService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('permission_permissions', $values);
        $this->assertInstanceOf(Permission::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can display a listing of the entity.
     *
     * @return void
     */
    public function testItCanListingEntity()
    {
        $amount = 2;
        factory(Permission::class, $amount)->create();

        $list = $this->permissionService->paginate();
        $data = current($list->items())->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $list);
        $this->assertEquals($amount, $list->total());

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can show the specified entity.
     *
     * @return void
     */
    public function testItCanShowEntity()
    {
        $fake = factory(Permission::class)->create();
        $entity = $this->permissionService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Permission::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can update the specified entity in storage.
     *
     * @return void
     */
    public function testItCanUpdateEntity()
    {
        $fake = factory(Permission::class)->create();
        $entity = $this->permissionService->find($fake->id);
        $data = [
            'name' => 'Name of permission testing updated',
            'guard_name' => 'web',
        ];

        $entity->update($data);

        $this->assertDatabaseHas('permission_permissions', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Permission::class)->create();

        $response = $this->permissionService->destroy($entity->id);

        $this->assertTrue($response);
    }

    /**
     * Test it can sync permissions the specified entity from storage.
     *
     * @return void
     */
    public function testItCanSyncPermissions()
    {
        $collection = $this->permissionService->sync();

        foreach (Module::all() as $module) {
            $permissions = config($module->getLowerName() . '.permissions');

            if ($permissions) {
                foreach ($permissions as $permission) {
                    $permission['guard'] = (!empty($permission['guard'])) ? $permission['guard'] : 'web';
                    $permission['module'] = $module->getName();

                    $test = $collection->search(function ($item) use ($permission) {
                        return $item['name'] == $permission['name'] &&
                            $item['title'] == $permission['title'] &&
                            $item['guard_name'] == $permission['guard'] &&
                            $item['module'] == $permission['module'];
                            $item['wasRecentlyCreated'] == true;
                    });
                    $this->assertNotFalse($test);
                }
            }
        }
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /**
     * Structure of response entity.
     *
     * @return array
     */
    private function dataStructure()
    {
        return [
            'id',
            'name',
            'guard_name',
        ];
    }
}