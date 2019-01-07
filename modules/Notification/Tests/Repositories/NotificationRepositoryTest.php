<?php

namespace Modules\Notification\Tests\Repositories;

use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\NotificationRepository;
use Tests\TestCase;

class NotificationRepositoryTest extends TestCase
{
    /**
     * The notification repository instance.
     *
     * @var NotificationRepository
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

        $this->repository = $this->app->make(NotificationRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), Notification::class);
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