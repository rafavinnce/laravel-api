<?php

namespace Modules\Operation\Tests\Repositories;

use Modules\Operation\Entities\Operation;
use Modules\Operation\Repositories\OperationRepository;
use Tests\TestCase;

class OperationRepositoryTest extends TestCase
{
    /**
     * The operation repository instance.
     *
     * @var OperationRepository
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

        $this->repository = $this->app->make(OperationRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Operation::class);
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