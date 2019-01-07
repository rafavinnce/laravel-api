<?php

namespace Modules\Account\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountControllerTest extends TestCase
{
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
    }

    /**
     * Test it can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItCanCreateResource()
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

        $response = $this->post(route('accounts.store'), array_merge(
            $values,
            ['password' => $password],
            $ignore
        ));

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($data[$key], $value);
        }

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure($this->jsonStructure());
        $this->assertTrue($data['is_active']);
        $this->assertFalse($data['is_superuser']);
        $this->assertFalse($data['is_staff']);
    }

    /**
     * Test it can show the specified resource.
     *
     * @return void
     */
    public function testItCanShowResource()
    {
        $token = factory(User::class)->create([
            'is_active' => true,
            'is_superuser' => false,
            'is_staff' => false,
        ])->createToken('TokenAccountTest')->token->id;

        $response = $this->get(route('accounts.show', ['token_id' => $token]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can update the specified resource in storage.
     *
     * @return void
     */
    public function testItCanUpdateResource()
    {
        $token = factory(User::class)->create([
            'is_active' => true,
            'is_superuser' => false,
            'is_staff' => false,
        ])->createToken('TokenAccountTest')->token->id;

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

        $response = $this->put(route('accounts.update', ['token_id' => $token]), array_merge(
            $values,
            ['password' => $password],
            $ignore
        ));

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($data[$key], $value);
        }

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
        $this->assertTrue($data['is_active']);
        $this->assertFalse($data['is_superuser']);
        $this->assertFalse($data['is_staff']);
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource()
    {
        $token = factory(User::class)->create([
            'is_active' => true,
            'is_superuser' => false,
            'is_staff' => false,
        ])->createToken('TokenAccountTest')->token->id;

        $response = $this->delete(route('accounts.destroy', ['token_id' => $token]));
        $response->assertStatus(Response::HTTP_NO_CONTENT);
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
     * Structure of response resource.
     *
     * @return array
     */
    private function jsonStructure()
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
            'created_at',
            'updated_at',
            'full_name',
            'avatar',
        ];
    }
}
