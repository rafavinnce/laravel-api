<?php

namespace Modules\Shipment\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Shipment\Entities\Shipment;
use Modules\Shipment\Services\ShipmentService;
use Tests\TestCase;

class ShipmentServiceTest extends TestCase
{

    /**
     * The driver service instance.
     *
     * @var ShipmentService
     */
    protected $shipmentService;

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

        $this->shipmentService = $this->app->make(ShipmentService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = factory(Shipment::class)->make()->toArray();

        $entity = $this->shipmentService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('shipment_shipments', $values);
        $this->assertInstanceOf(Shipment::class, $entity);

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
        factory(Shipment::class, $amount)->create();

        $list = $this->shipmentService->paginate();
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
        $fake = factory(Shipment::class)->create();
        $entity = $this->shipmentService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Shipment::class, $entity);

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
        $fake = factory(Shipment::class)->create();
        $entity = $this->shipmentService->find($fake->id);

        $data = factory(Shipment::class)->make()->toArray();

        $entity->update($data);

        $this->assertDatabaseHas('shipment_shipments', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Shipment::class)->create();

        $response = $this->shipmentService->destroy($entity->id);

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
            'wait_id',
            'dock_id',
            'box',
            'carrier_id',
            'operation_id',
            'created_at',
            'updated_at',
        ];
    }
}