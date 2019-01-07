<?php

namespace Modules\Wait\Tests\Repositories;

use Modules\Wait\Entities\Wait;
use Modules\Wait\Repositories\WaitRepository;
use Tests\TestCase;

class WaitRepositoryTest extends TestCase
{
    /**
     * The wait repository instance.
     *
     * @var WaitRepository
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

        $this->repository = $this->app->make(WaitRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Wait::class);
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