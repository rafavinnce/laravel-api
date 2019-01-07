<?php

namespace Modules\Status\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\Status\Entities\Status;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusControllerTest extends TestCase
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
     * Test it can display a listing of the resource.
     *
     * @return void
     */
    public function testItCanListingResource()
    {
        $amount = 2;

        factory(Status::class, $amount)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('status.index'));

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
        $entity = factory(Status::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('status.show', ['status' => $entity->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());
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
            'code',
            'type',
            'created_at',
            'updated_at',
        ];
    }
}
