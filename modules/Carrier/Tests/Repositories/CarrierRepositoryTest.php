<?php

namespace Modules\Carrier\Tests\Repositories;

use Modules\Carrier\Entities\Carrier;
use Modules\Carrier\Repositories\CarrierRepository;
use Tests\TestCase;

class CarrierRepositoryTest extends TestCase
{
    /**
     * The carrier repository instance.
     *
     * @var CarrierRepository
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

        $this->repository = $this->app->make(CarrierRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Carrier::class);
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