<?php

namespace Modules\Carrier\Tests\Services;

use Faker\Provider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Carrier\Entities\Carrier;
use Modules\Carrier\Services\CarrierService;
use Tests\TestCase;

class CarrierServiceTest extends TestCase
{
    use WithFaker;

    /**
     * The carrier service instance.
     *
     * @var CarrierService
     */
    protected $carrierService;

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

        $this->faker->addProvider(new Provider\pt_BR\Company($this->faker));

        $this->carrierService = $this->app->make(CarrierService::class);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity()
    {
        $values = factory(Carrier::class)->make()->toArray();

        $entity = $this->carrierService->create($values);
        $data = $entity->toArray();

        $this->assertDatabaseHas('carrier_carriers', $values);
        $this->assertInstanceOf(Carrier::class, $entity);

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
        factory(Carrier::class, $amount)->create();

        $list = $this->carrierService->paginate();
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
        $fake = factory(Carrier::class)->create();
        $entity = $this->carrierService->find($fake->id);
        $data = $entity->toArray();

        $this->assertInstanceOf(Carrier::class, $entity);

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
        $fake = factory(Carrier::class)->create();
        $entity = $this->carrierService->find($fake->id);
        $values = factory(Carrier::class)->make()->toArray();

        $entity->update($values);

        $this->assertDatabaseHas('carrier_carriers', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity()
    {
        $entity = factory(Carrier::class)->create();

        $response = $this->carrierService->destroy($entity->id);

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
            'id_external',
            'created_at',
            'updated_at',
        ];
    }
}