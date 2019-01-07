<?php

namespace Modules\Vehicle\Tests\Repositories;

use Modules\Vehicle\Entities\Vehicle;
use Modules\Vehicle\Repositories\VehicleRepository;
use Tests\TestCase;

class VehicleRepositoryTest extends TestCase
{
    /**
     * The vehicle repository instance.
     *
     * @var VehicleRepository
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

        $this->repository = $this->app->make(VehicleRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Vehicle::class);
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