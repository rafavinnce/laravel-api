<?php

namespace Modules\User\Tests\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Services\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('passport:install');

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $password = 'testpass';
        $values = [
            'first_name' => 'First name staff test',
            'last_name' => 'Last name staff test',
            'email' => 'staff-test@testing.org',
            'is_active' => true,
            'is_alert_phone' => true,
            'is_alert_mail' => true,
            'is_superuser' => false,
            'is_staff' => true,
            'retention_list_limit' => '1440',
        ];

        $entity = $this->userService->create(array_merge(
            $values,
            ['password' => $password]
        ));
        $data = $entity->toArray();

        $this->assertDatabaseHas('user_users', $values);
        $this->assertInstanceOf(User::class, $entity);
        $this->assertTrue(Hash::check($password, $entity->password));

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can display a listing of the entity.
     *
     * @return void
     */
    public function testItCanListingEntity()
    {
        $amount = 2;
        factory(User::class, $amount)->create();

        $list = $this->userService->paginate();
        $data = current($list->items())->toArray();

        $this->assertInstanceOf(LengthAwarePaginator::class, $list);
        $this->assertEquals($amount, $list->total());

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can show the specified entity.
     *
     * @return void
     */
    public function testItCanShowEntity()
    {
        $fake = factory(User::class)->create();
        $entity = $this->userService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(User::class, $entity);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can update the specified entity in storage.
     *
     * @return void
     */
    public function testItCanUpdateEntity()
    {
        $fake = factory(User::class)->create();
        $entity = $this->userService->find($fake->id);
        $data = [
            'first_name' => 'First name update test',
            'last_name' => 'Last name update test',
            'email' => 'update@testing.org',
            'is_active' => true,
            'is_superuser' => true,
            'is_staff' => true,
            'retention_list_limit' => '1440',
        ];

        $entity->update($data);

        $this->assertDatabaseHas('user_users', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(User::class)->create();

        $response = $this->userService->destroy($entity->id);

        $this->assertTrue($response);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /**
     * Structure of response entity.
     *
     * @return array
     */
    private function dataStructure()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
            'is_active',
            'is_superuser',
            'is_staff',
            'is_alert_phone',
            'is_alert_mail',
            'retention_list_limit',
            'created_at',
            'updated_at',
            'full_name',
            'avatar',
        ];
    }
}