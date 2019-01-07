<?php

namespace Modules\Account\Tests\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\Account\Services\AccountService;
use Tests\TestCase;

class AccountServiceTest extends TestCase
{
    /**
     * The account service instance.
     *
     * @var AccountService
     */
    protected $accountService;

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

        $this->accountService = $this->app->make(AccountService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'first_name' => 'First name account',
            'last_name' => 'Last name account',
            'email' => 'account@testing.org',
        ];
        $ignore = [
            'is_active' => false,
            'is_superuser' => true,
            'is_staff' => true,
        ];
        $password = 'testpass';

        $entity = $this->accountService->create(array_merge(
            $values,
            ['password' => $password],
            $ignore
        ));
        $data = $entity->toArray();

        $this->assertDatabaseHas('user_users', $values);
        $this->assertInstanceOf(User::class, $entity);
        $this->assertTrue(Hash::check($password, $entity->password));
        $this->assertTrue($entity->is_active);
        $this->assertFalse($entity->is_superuser);
        $this->assertFalse($entity->is_staff);

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
        $token = factory(User::class)->create([
            'is_active' => true,
            'is_superuser' => false,
            'is_staff' => false,
        ])->createToken('TokenAccountTest')->token->id;

        $entity = $this->accountService->find($token);
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
        $values = [
            'first_name' => 'First name account update',
            'last_name' => 'Last name account update',
            'email' => 'account-update@testing.org',
        ];
        $ignore = [
            'is_active' => false,
            'is_superuser' => true,
            'is_staff' => true,
        ];
        $password = 'testpassupdate';

        $token = factory(User::class)->create([
            'is_active' => true,
            'is_superuser' => false,
            'is_staff' => false,
        ])->createToken('TokenAccountTest')->token->id;

        $entity = $this->accountService->update(array_merge(
            $values, $ignore, ['password' => $password]
        ), $token);

        $data = $entity->toArray();
        $this->assertDatabaseHas('user_users', $values);
        $this->assertInstanceOf(User::class, $entity);
        $this->assertTrue(Hash::check($password, $entity->password));
        $this->assertTrue($entity->is_active);
        $this->assertFalse($entity->is_superuser);
        $this->assertFalse($entity->is_staff);

        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $token = factory(User::class)->create([
            'is_active' => true,
            'is_superuser' => false,
            'is_staff' => false,
        ])->createToken('TokenAccountTest')->token->id;

        $response = $this->accountService->destroy($token);
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
            'created_at',
            'updated_at',
            'full_name',
            'avatar',
        ];
    }
}