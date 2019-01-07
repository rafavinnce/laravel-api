<?php

namespace Modules\Operation\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Operation\Entities\Operation;
use Modules\Operation\Services\OperationService;
use Tests\TestCase;

class OperationServiceTest extends TestCase
{
    /**
     * The operation service instance.
     *
     * @var OperationService
     */
    protected $operationService;

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

        $this->operationService = $this->app->make(OperationService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'name' => 'Operation testing',
        ];

        $entity = $this->operationService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('operation_operations', $values);
        $this->assertInstanceOf(Operation::class, $entity);

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
        factory(Operation::class, $amount)->create();

        $list = $this->operationService->paginate();
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
        $fake = factory(Operation::class)->create();
        $entity = $this->operationService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Operation::class, $entity);

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
        $fake = factory(Operation::class)->create();
        $entity = $this->operationService->find($fake->id);
        $data = [
            'name' => 'Name of operation testing updated',
        ];

        $entity->update($data);

        $this->assertDatabaseHas('operation_operations', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Operation::class)->create();

        $response = $this->operationService->destroy($entity->id);

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
            'created_at',
            'updated_at',
        ];
    }
}