<?php

namespace Modules\Permission\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Permission\Entities\Role;
use Modules\Permission\Services\RoleService;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    /**
     * The role service instance.
     *
     * @var RoleService
     */
    protected $roleService;

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

        $this->roleService = $this->app->make(RoleService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'name' => 'Name of role testing',
            'guard_name' => 'web',
        ];

        $entity = $this->roleService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('permission_roles', $values);
        $this->assertInstanceOf(Role::class, $entity);

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
        factory(Role::class, $amount)->create();

        $list = $this->roleService->paginate();
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
        $fake = factory(Role::class)->create();
        $entity = $this->roleService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Role::class, $entity);

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
        $fake = factory(Role::class)->create();
        $entity = $this->roleService->find($fake->id);
        $data = [
            'name' => 'Name of role testing updated',
            'guard_name' => 'web',
        ];

        $entity->update($data);

        $this->assertDatabaseHas('permission_roles', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Role::class)->create();

        $response = $this->roleService->destroy($entity->id);

        $this->assertTrue($response);
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