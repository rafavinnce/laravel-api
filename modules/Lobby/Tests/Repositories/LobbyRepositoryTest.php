<?php

namespace Modules\Lobby\Tests\Repositories;

use Modules\Lobby\Entities\Lobby;
use Modules\Lobby\Repositories\LobbyRepository;
use Tests\TestCase;

class LobbyRepositoryTest extends TestCase
{
    /**
     * The driver repository instance.
     *
     * @var LobbyRepository
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

        $this->repository = $this->app->make(LobbyRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Lobby::class);
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