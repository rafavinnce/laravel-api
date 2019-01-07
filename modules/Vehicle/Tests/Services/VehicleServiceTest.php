<?php

namespace Modules\Vehicle\Tests\Services;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Vehicle\Entities\Vehicle;
use Modules\Vehicle\Services\VehicleService;
use Tests\TestCase;

class VehicleServiceTest extends TestCase
{
    use WithFaker;

    /**
     * The vehicle service instance.
     *
     * @var VehicleService
     */
    protected $vehicleService;

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

        $this->vehicleService = $this->app->make(VehicleService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'board' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];

        $entity = $this->vehicleService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('vehicle_vehicles', $values);
        $this->assertInstanceOf(Vehicle::class, $entity);

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
        factory(Vehicle::class, $amount)->create();

        $list = $this->vehicleService->paginate();
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
        $fake = factory(Vehicle::class)->create();
        $entity = $this->vehicleService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Vehicle::class, $entity);

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
        $fake = factory(Vehicle::class)->create();
        $entity = $this->vehicleService->find($fake->id);
        $data = [
            'board' => $this->faker->regexify('[A-Z]{3}-[0-9]{4}'),
        ];

        $entity->update($data);

        $this->assertDatabaseHas('vehicle_vehicles', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Vehicle::class)->create();

        $response = $this->vehicleService->destroy($entity->id);

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
            'board',
            'created_at',
            'updated_at',
        ];
    }
}