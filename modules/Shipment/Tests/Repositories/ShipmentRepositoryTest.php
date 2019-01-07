<?php

namespace Modules\Shipment\Tests\Repositories;

use Modules\Shipment\Entities\Shipment;
use Modules\Shipment\Repositories\ShipmentRepository;
use Tests\TestCase;

class ShipmentRepositoryTest extends TestCase
{
    /**
     * The driver repository instance.
     *
     * @var ShipmentRepository
     */
    protected $repository;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->repository = $this->app->make(ShipmentRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Shipment::class);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}