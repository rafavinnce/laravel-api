<?php

namespace Modules\Permission\Tests\Repositories;

use Modules\Permission\Entities\Permission;
use Modules\Permission\Repositories\PermissionRepository;
use Tests\TestCase;

class PermissionRepositoryTest extends TestCase
{
    /**
     * The permission repository instance.
     *
     * @var PermissionRepository
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

        $this->repository = $this->app->make(PermissionRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Permission::class);
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