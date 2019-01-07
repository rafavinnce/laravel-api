<?php

namespace Modules\Dock\Tests\Repositories;

use Modules\Dock\Entities\Dock;
use Modules\Dock\Repositories\DockRepository;
use Tests\TestCase;

class DockRepositoryTest extends TestCase
{
    /**
     * The driver repository instance.
     *
     * @var DockRepository
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

        $this->repository = $this->app->make(DockRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Dock::class);
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