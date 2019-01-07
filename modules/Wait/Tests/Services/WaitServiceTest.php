<?php

namespace Modules\Wait\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Wait\Entities\Wait;
use Modules\Wait\Services\WaitService;
use Tests\TestCase;

class WaitServiceTest extends TestCase
{
    /**
     * The wait service instance.
     *
     * @var WaitService
     */
    protected $waitService;

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

        $this->waitService = $this->app->make(WaitService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = factory(Wait::class)->make()->toArray();

        $entity = $this->waitService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('wait_waits', $values);
        $this->assertInstanceOf(Wait::class, $entity);

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
        factory(Wait::class, $amount)->create();

        $list = $this->waitService->paginate();
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
        $fake = factory(Wait::class)->create();
        $entity = $this->waitService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Wait::class, $entity);

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
        $fake = factory(Wait::class)->create();
        $entity = $this->waitService->find($fake->id);
        $values = factory(Wait::class)->make()->toArray();

        $entity->update($values);

        $this->assertDatabaseHas('wait_waits', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Wait::class)->create();

        $response = $this->waitService->destroy($entity->id);

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
            'id', 'driver', 'manifest', 'seal1', 'seal2', 'authorized_by', 'arrival_at', 'entry_at', 'output_at',
            'operation_id', 'lobby_id', 'board_cart_id', 'board_horse_id', 'carrier_id', 'created_at', 'updated_at',
        ];
    }
}