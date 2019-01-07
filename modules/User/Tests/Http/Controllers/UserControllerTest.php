<?php

namespace Modules\User\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
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
        Artisan::call('permission:migrate');

        $this->token['superuser'] = factory(User::class)->create([
            'email' => 'superuser@testing.org',
            'first_name' => 'First name superuser',
            'last_name' => 'Last name superuser',
            'is_active' => true,
            'is_superuser' => true,
            'is_staff' => false,
            'is_alert_phone' => true,
            'is_alert_mail' => true,
            'password' => 'testpass',
        ])->createToken('TokenSuperuserTest')->accessToken;
    }

    /**
     * Test it can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItCanCreateResource()
    {
        $values = array_merge(['password' => 'testpass'], factory(User::class)->make()->toArray());

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->post(route('users.store'), $values);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can display a listing of the resource.
     *
     * @return void
     */
    public function testItCanListingResource()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('users.index'));

        $first = current($response->json('data'));

        $response->assertStatus(Response::HTTP_OK);
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
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('users.show', ['user' => 1]));

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
        $values = factory(User::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->put(route('users.update', ['user' => 1]), $values);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->delete(route('users.destroy', ['user' => 1]));

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
            'created_at',
            'updated_at',
            'full_name',
            'avatar',
            'is_alert_phone',
            'is_alert_mail',
        ];
    }
}
