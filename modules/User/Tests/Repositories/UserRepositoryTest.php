<?php

namespace Modules\User\Tests\Repositories;

use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepository;
use Modules\User\Validators\UserValidator;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
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

        $this->repository = $this->app->make(UserRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName()
    {
        $this->assertEquals($this->repository->model(), User::class);
    }

    /**
     * Test it can specify validator class name.
     *
     * @return void
     */
    public function testItCanSpecifyValidatorClassName()
    {
        $this->assertEquals($this->repository->validator(), UserValidator::class);
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