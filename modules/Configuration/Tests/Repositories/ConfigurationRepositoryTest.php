<?php

namespace Modules\Configuration\Tests\Repositories;

use Modules\Configuration\Entities\Configuration;
use Modules\Configuration\Repositories\ConfigurationRepository;
use Tests\TestCase;

class ConfigurationRepositoryTest extends TestCase
{
    /**
     * The driver repository instance.
     *
     * @var ConfigurationRepository
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

        $this->repository = $this->app->make(ConfigurationRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Configuration::class);
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