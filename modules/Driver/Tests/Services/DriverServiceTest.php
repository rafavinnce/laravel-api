<?php

namespace Modules\Driver\Tests\Services;

use Faker\Provider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Driver\Entities\Driver;
use Modules\Driver\Services\DriverService;
use Tests\TestCase;

class DriverServiceTest extends TestCase
{
    use WithFaker;

    /**
     * The driver service instance.
     *
     * @var DriverService
     */
    protected $driverService;

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

        $this->faker->addProvider(new Provider\pt_BR\Person($this->faker));

        $this->driverService = $this->app->make(DriverService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = [
            'name' => 'Driver testing',
            'document' => $this->faker->cpf(),
        ];

        $entity = $this->driverService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('driver_drivers', $values);
        $this->assertInstanceOf(Driver::class, $entity);

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
        factory(Driver::class, $amount)->create();

        $list = $this->driverService->paginate();
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
        $fake = factory(Driver::class)->create();
        $entity = $this->driverService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Driver::class, $entity);

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
        $fake = factory(Driver::class)->create();
        $entity = $this->driverService->find($fake->id);
        $data = [
            'name' => 'Name of driver testing updated',
            'document' => $this->faker->cpf(),
        ];

        $entity->update($data);

        $this->assertDatabaseHas('driver_drivers', $data);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Driver::class)->create();

        $response = $this->driverService->destroy($entity->id);

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
            'name',
            'document',
        ];
    }
}