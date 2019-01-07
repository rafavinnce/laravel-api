<?php

namespace Modules\Status\Tests\Repositories;

use Modules\Status\Entities\Status;
use Modules\Status\Repositories\StatusRepository;
use Tests\TestCase;

class StatusRepositoryTest extends TestCase
{
    /**
     * The status repository instance.
     *
     * @var StatusRepository
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

        $this->repository = $this->app->make(StatusRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Status::class);
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