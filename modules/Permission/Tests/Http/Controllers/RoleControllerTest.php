<?php

namespace Modules\Permission\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\Address\Entities\City;
use Modules\Address\Entities\State;
use Modules\Permission\Entities\Role;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
{
    /**
     * Access tokens.
     *
     * @var string
     */
    protected $token = [];

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

        $this->token['superuser'] = factory(User::class)->create([
            'email'        => 'superuser@testing.org',
            'first_name'   => 'First name superuser',
            'last_name'    => 'Last name superuser',
            'is_active'    => true,
            'is_superuser' => true,
            'is_staff'     => false,
            'password'     => 'testpass',
        ])->createToken('TokenSuperuserTest')->accessToken;

        $this->token['staff'] = factory(User::class)->create([
            'email'        => 'staff@testing.org',
            'first_name'   => 'First name staff',
            'last_name'    => 'Last name staff',
            'is_active'    => true,
            'is_superuser' => false,
            'is_staff'     => true,
            'password'     => 'testpass',
        ])->createToken('TokenStaffTest')->accessToken;
    }

    /**
     * Test it can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItCanCreateResource()
    {
        $values = [
            'name' => 'Role testing',
            'guard_name' => 'web',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->post(route('roles.store'), $values);

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($value, $data[$key]);
        }

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it staff not can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItStaffNotCanCreateResource()
    {
        $values = [
            'name' => 'Role testing',
            'guard_name' => 'web',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->post(route('roles.store'), $values);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test it can display a listing of the resource.
     *
     * @return void
     */
    public function testItCanListingResource()
    {
        $amount = 2;

        factory(Role::class, $amount)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('roles.index'));

        $first = current($response->json('data'));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($amount, $response->json('total'));
        foreach ($this->jsonStructure() as $key) {
            $this->assertArrayHasKey($key, $first);
        }
    }

    /**
     * Test it can show the specified resource.
     *
     * @return void
     */
    public function testItCanShowResource()
    {
        $entity = factory(Role::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('roles.show', ['role' => $entity->id]));

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
        $entity = factory(Role::class)->create();

        $values = [
            'name' => 'Name of role testing',
            'guard_name' => 'web',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->put(route('roles.update', ['role' => $entity->id]), $values);

        $data = $response->json();

        foreach ($values as $key => $value) {
            $this->assertEquals($value, $data[$key]);
        }

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it staff not can update the specified resource in storage.
     *
     * @return void
     */
    public function testItStaffNotCanUpdateResource()
    {
        $entity = factory(Role::class)->create();

        $values = [
            'name' => 'Name of role testing updated',
            'guard_name' => 'web',
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->put(route('roles.update', ['role' => $entity->id]), $values);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource()
    {
        $entity = factory(Role::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->delete(route('roles.destroy', ['role' => $entity->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Test it staff not can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItStaffNotCanDestroyResource()
    {
        $entity = factory(Role::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->delete(route('roles.destroy', ['role' => $entity->id]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
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
            'name',
            'guard_name',
            'created_at',
            'updated_at',
        ];
    }
}
