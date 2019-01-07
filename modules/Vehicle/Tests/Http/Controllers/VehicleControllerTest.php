<?php

namespace Modules\Vehicle\Tests\Http\Controllers\Tests;

use Faker\Provider;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\Vehicle\Entities\Vehicle;
use Modules\User\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleControllerTest extends TestCase
{
    use WithFaker;

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

        $this->faker->addProvider(new Provider\pt_BR\Person($this->faker));

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
            'board' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->post(route('vehicles.store'), $values);

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
        $values = [
            'board' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->post(route('vehicles.store'), $values);

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

        factory(Vehicle::class, $amount)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('vehicles.index'));

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
        $entity = factory(Vehicle::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->get(route('vehicles.show', ['vehicle' => $entity->id]));

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
        $entity = factory(Vehicle::class)->create();

        $values = [
            'board' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->put(route('vehicles.update', ['vehicle' => $entity->id]), $values);

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
        $entity = factory(Vehicle::class)->create();

        $values = [
            'board' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->put(route('vehicles.update', ['vehicle' => $entity->id]), $values);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test it can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItCanDestroyResource()
    {
        $entity = factory(Vehicle::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['superuser']}",
            'Accept' => 'application/json',
        ])->delete(route('vehicles.destroy', ['vehicle' => $entity->id]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * Test it staff not can remove the specified resource from storage.
     *
     * @return void
     */
    public function testItStaffNotCanDestroyResource()
    {
        $entity = factory(Vehicle::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->token['staff']}",
            'Accept' => 'application/json',
        ])->delete(route('vehicles.destroy', ['vehicle' => $entity->id]));

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
            'board',
            'created_at',
            'updated_at',
        ];
    }
}
