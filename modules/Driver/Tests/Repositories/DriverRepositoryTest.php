<?php

namespace Modules\Driver\Tests\Repositories;

use Modules\Driver\Entities\Driver;
use Modules\Driver\Repositories\DriverRepository;
use Tests\TestCase;

class DriverRepositoryTest extends TestCase
{
    /**
     * The driver repository instance.
     *
     * @var DriverRepository
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

        $this->repository = $this->app->make(DriverRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Driver::class);
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