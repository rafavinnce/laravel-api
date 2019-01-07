<?php

namespace Modules\Shipment\Tests\Http\Controllers\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\Shipment\Entities\Shipment;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipmentControllerTest extends TestCase
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
     * Test it can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItCanCreateResource()
    {
        $values = factory(Shipment::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->post(route('shipments.store'), $values);

        $data = $response->json();

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure($this->jsonStructure());

        foreach ($values as $key => $value) {
            $this->assertEquals($value, $data[$key]);
        }
    }

    /**
     * Test it staff not can store a newly created resource in storage.
     *
     * @return void
     */
    public function testItStaffNotCanCreateResource()
    {
        $values = factory(Shipment::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->post(route('shipments.store'), $values);

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

        factory(Shipment::class, $amount)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('shipments.index'));

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
        $entity = factory(Shipment::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('shipments.show', ['driver' => $entity->id]));

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
        $entity = factory(Shipment::class)->create();

        $values = factory(Shipment::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->put(route('shipments.update', ['shipment' => $entity->id]), $values);

        $data = $response->json();

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->jsonStructure());

        foreach ($values as $key => $value) {
            $this->assertEquals($value, $data[$key]);
        }
    }

    /**
     * Test it staff not can update the specified resource in storage.
     *
     * @return void
     */
    public function testItStaffNotCanUpdateResource()
    {
        $entity = factory(Shipment::class)->create();

        $values = factory(Shipment::class)->make()->toArray();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->put(route('shipments.update', ['shipment' => $entity->id]), $values);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource()
    {
        $entity = factory(Shipment::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->delete(route('shipments.destroy', ['shipment' => $entity->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Test it staff not can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItStaffNotCanDestroyResource()
    {
        $entity = factory(Shipment::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->delete(route('shipments.destroy', ['shipment' => $entity->id]));

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
            'wait_id',
            'dock_id',
            'box',
            'carrier_id',
            'operation_id',
            'created_at',
            'updated_at',
        ];
    }
}
